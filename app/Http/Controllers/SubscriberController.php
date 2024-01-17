<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriberRequest;
use App\Mail\SubscribersMail;
use App\Models\Subscriber;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class SubscriberController extends Controller
{

    public function index()
    {
        $trashedSubscribers = Subscriber::onlyTrashed()->get();
        $subscribers = Subscriber::all();
        return view('subscribers', [
            'subscribers' => $subscribers,
            'trashedSubscribers' => $trashedSubscribers,
        ]);
    }

    public function store(SubscriberRequest $request)
    {
        try {
            $subscriber = Subscriber::create([
                'email' => $request->input('email'),
                'name' => $request->input('name'),
            ]);
    
            return response()->json(['message' => 'Subscriber added successfully'], 201);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
    
            return response()->json(['error' => 'An error occurred while processing your request.'], 500);
        }
    }

    public function softDeleteSubscriber(Request $request, $id)
    {
        $subscriber = Subscriber::findOrFail($id);

        $subscriber->delete();

        return response()->json(['message' => 'Subscriber soft-deleted successfully']);
    }

    
    public function permDelete(Request $request, $id)
    {
        try {
            $subscriber = Subscriber::withTrashed()->findOrFail($id);
            $subscriber->forceDelete();
        } catch (ModelNotFoundException $e) {
            return redirect()->route('editor.subscribers')->with('error', 'Subscriber not found.');
        } catch (\Exception $e) {
            return redirect()->route('editor.subscribers')->with('error', 'Error deleting subscriber.');
        }
        return redirect()->route('editor.subscribers')->with('success', 'Subscriber permanently deleted.');
    }


    public function destroy(Request $request, $id)
    {
        try {
            $subscriber = Subscriber::findOrFail($id);
            $subscriber->delete();

            Session::flash('success', 'Subscriber deleted successfully');
        } catch (ModelNotFoundException $e) {
            Session::flash('error', 'Subscriber not found.');
        } catch (\Exception $e) {
            Session::flash('error', 'Error deleting subscriber.');
        }

        return redirect()->route('editor.subscribers');
    }

    public function restoreSubscriber($id)
    {
        $subscriber = Subscriber::withTrashed()->findOrFail($id);

        if ($subscriber->trashed()) {
            $subscriber->restore();
            return response()->json(['message' => 'Subscriber restored successfully']);
        } else {
            return response()->json(['message' => 'Subscriber is not soft-deleted'], 422);
        }
    }

    public function restoreSubscriberWeb($id)
    {
        try {
            $subscriber = Subscriber::withTrashed()->findOrFail($id);
            $subscriber->restore();

            Session::flash('success', 'Subscriber restored successfully');
        } catch (ModelNotFoundException $e) {
            Session::flash('error', 'Subscriber not found.');
        } catch (\Exception $e) {
            Session::flash('error', 'Error restoring subscriber.');
        }

        return redirect()->route('editor.subscribers');
    }


    public function sendEmailToSubscribers(Request $request)
    {
        $request->validate([
            'answer' => 'required',
        ]);
    
        $subscribers = Subscriber::all();
    
        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)->send(new SubscribersMail($request->input('answer'), $subscriber->id));
        }
    
        return redirect()->route('editor.subscribers')->with('success', 'Email sent to all subscribers successfully');
    }
}
