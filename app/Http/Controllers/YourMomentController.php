<?php

namespace App\Http\Controllers;

use App\Models\YourMoment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class YourMomentController extends Controller
{

    public function index()
    {
        $trashedMoments = YourMoment::onlyTrashed()->get();
        $moments = YourMoment::orderBy('priority')->get();
    
        return view('moments.index', [
            'moments' => $moments,
            'trashedMoments' => $trashedMoments,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'nullable|string',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            
            
            $maxPriority = YourMoment::max('priority');
            $priority = ($maxPriority !== null) ? (int)$maxPriority + 1 : 1;
            $imagePath = $request->file('image')->store('moments', 'public');
    
            YourMoment::create([
                'title' => $request->input('title'),
                'filename' => $imagePath,
                'priority' => $priority,
            ]);
    
            return Redirect::route('moments.index')->with('success', 'Moment added successfully');
        }  catch (\Illuminate\Validation\ValidationException $e) {
            // Catch the validation exception
            $errorMessage = $e->validator->errors()->first();
    
            // Redirect back with the error message and old input
            return Redirect::back()->withErrors([$errorMessage])->withInput();
        } catch (\Exception $e) {
            // Log the error
           Log::error($e->getMessage());
    
            // Redirect back with old input and error message
            return Redirect::back()->withErrors([$e->getMessage()])->withInput();
        }
    }

    public function softDelete(Request $request, $id)
    {
        $moment = YourMoment::findOrFail($id);

        $moment->delete();

        $this->updatePriorities();

        return redirect()->route('moments.index')->with('success', 'Moment removed successfully.');
    }

    public function restoreMoment($id)
    {
        $moment = YourMoment::withTrashed()->findOrFail($id);

        if ($moment->trashed()) {
            $moment->restore();
            $this->updatePriorities();
            return redirect()->route('moments.index')->with('success', 'Moment restored successfully.');
        } else {
            return redirect()->route('moments.index');
        }
    }

    public function permDelete(Request $request, $id)
    {
        $moment = YourMoment::withTrashed()->findOrFail($id);

        $moment->forceDelete();

        return redirect()->route('moments.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $moment = YourMoment::findOrFail($id);

            return view('moments.edit', compact('moment'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(['Something went wrong. Please try again.']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'string|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $moment = YourMoment::findOrFail($id);

        $moment->title = $request->input('title');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/moments', $filename);
            $moment->filename = 'moments/' . $filename;
        }

        $moment->save();

        return redirect()->route('moments.index', $moment->id)->with('success', 'Moment updated successfully');
    }

    public function moveUp($id)
    {
        $moment = YourMoment::findOrFail($id);
        $currentPriority = $moment->priority;
    
        if ($currentPriority > 1) {
            $previousMoment = YourMoment::where('priority', $currentPriority - 1)->first();
    
            if ($previousMoment) {
                $moment->priority = $currentPriority - 1;
                $previousMoment->priority = $currentPriority;
    
                $moment->save();
                $previousMoment->save();
    
                $this->updatePriorities();
    
                return redirect()->route('moments.index')->with('success', 'Moment moved up successfully');
            }
        }
    
        return redirect()->route('moments.index')->with('error', 'Unable to move Moment up');
    }

    private function updatePriorities()
    {
        $moments = YourMoment::orderBy('priority')->get();
        $priority = 1;
    
        foreach ($moments as $moment) {
            $moment->priority = $priority++;
            $moment->save();
        }
    }

    public function moveDown($id)
    {
        $moment = YourMoment::findOrFail($id);
        $currentPriority = $moment->priority;
    
        $maxPriority = YourMoment::max('priority');
    
        if ($currentPriority < $maxPriority) {
            $nextMoment = YourMoment::where('priority', $currentPriority + 1)->first();
    
            if ($nextMoment) {
                $moment->priority = $currentPriority + 1;
                $nextMoment->priority = $currentPriority;
    
                $moment->save();
                $nextMoment->save();
    
                $this->updatePriorities();
    
                return redirect()->route('moments.index')->with('success', 'Moment moved down successfully');
            }
        }
    
        return redirect()->route('moments.index')->with('error', 'Unable to move moment down');
    }

}
