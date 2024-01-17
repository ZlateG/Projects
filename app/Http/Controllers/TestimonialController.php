<?php

namespace App\Http\Controllers;



use App\Http\Requests\TestemonialRequest;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class TestimonialController  extends Controller
{

    public function index()
    {
        $trashedTestimonials = Testimonial::onlyTrashed()->get();
        $testimonials = Testimonial::orderBy('priority')->get();
    
        return view('testimonials.index', [
            'testimonials' => $testimonials,
            'trashedTestimonials' => $trashedTestimonials,
        ]);
    }


    public function store(TestemonialRequest $request)
    {
        try {
            $maxPriority = Testimonial::max('priority');
            $priority = ($maxPriority !== null) ? (int)$maxPriority + 1 : 1;
            $imagePath = $request->file('image')->store('testimonials', 'public');
    
            Testimonial::create([
                'title' => $request->input('title'),
                'location' => $request->input('location'),
                'description' => $request->input('description'),
                'rating' => $request->input('rating'),
                'filename' => $imagePath,
                'priority' => $priority,
            ]);
    
            return Redirect::route('testimonials.index')->with('success', 'Testimonial added successfully');
        }  catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessage = $e->validator->errors()->first();
    
            return Redirect::back()->withErrors([$errorMessage])->withInput();
        } catch (\Exception $e) {
           Log::error($e->getMessage());
    
            return Redirect::back()->withErrors([$e->getMessage()])->withInput();
        }
    }
    
  
    public function softDelete(Request $request, $id)
    {
        $testemonial = Testimonial::findOrFail($id);

        $testemonial->delete();
        $this->updatePriorities();

        return redirect()->route('testimonials.index')->with('success', 'Testimonial removed successfully.');
    }

    public function restoreTestimonial($id)
    {
        $testemonial = Testimonial::withTrashed()->findOrFail($id);

        if ($testemonial->trashed()) {
            $testemonial->restore();
            $this->updatePriorities();
            return redirect()->route('testimonials.index')->with('success', 'Testimonial restored successfully.');
        } else {
            return redirect()->route('testimonials.index');
        }
    }

    public function permDelete(Request $request, $id)
    {
        $testemonial = Testimonial::withTrashed()->findOrFail($id);

        $testemonial->forceDelete();

        return redirect()->route('testimonials.index');
    }


    public function edit($id)
    {
        try {
            $testimonial = Testimonial::findOrFail($id);

            return view('testimonials.edit', compact('testimonial'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(['Something went wrong. Please try again.']);
        }
    }

    public function update(TestemonialRequest $request, $id)
    {

        $testimonial = Testimonial::findOrFail($id);

        $testimonial->title = $request->input('title');
        $testimonial->location = $request->input('location');
        $testimonial->description = $request->input('description');
        $testimonial->rating = $request->input('rating');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/testimonials', $filename);
            $testimonial->filename = 'testimonials/' . $filename;
        }

        $testimonial->save();

        return redirect()->route('testimonials.index', $testimonial->id)->with('success', 'Testimonial updated successfully');
    }

    
    public function moveUp($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $currentPriority = $testimonial->priority;
    
        if ($currentPriority > 1) {
            $previousTestimonial = Testimonial::where('priority', $currentPriority - 1)->first();
    
            if ($previousTestimonial) {
                $testimonial->priority = $currentPriority - 1;
                $previousTestimonial->priority = $currentPriority;
    
                $testimonial->save();
                $previousTestimonial->save();
    
                $this->updatePriorities();
    
                return redirect()->route('testimonials.index')->with('success', 'Testimonial moved up successfully');
            }
        }
    
        return redirect()->route('testimonials.index')->with('error', 'Unable to move testimonial up');
    }
    
    private function updatePriorities()
    {
        $testimonials = Testimonial::orderBy('priority')->get();
        $priority = 1;
    
        foreach ($testimonials as $testimonial) {
            $testimonial->priority = $priority++;
            $testimonial->save();
        }
    }

    public function moveDown($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $currentPriority = $testimonial->priority;
    
        $maxPriority = Testimonial::max('priority');
    
        if ($currentPriority < $maxPriority) {
            $nextTestimonial = Testimonial::where('priority', $currentPriority + 1)->first();
    
            if ($nextTestimonial) {
                // Swap priorities between the current and next testimonials
                $testimonial->priority = $currentPriority + 1;
                $nextTestimonial->priority = $currentPriority;
    
                // Save the changes
                $testimonial->save();
                $nextTestimonial->save();
    
                $this->updatePriorities();
    
                return redirect()->route('testimonials.index')->with('success', 'Testimonial moved down successfully');
            }
        }
    
        return redirect()->route('testimonials.index')->with('error', 'Unable to move testimonial down');
    }

 
    









}
