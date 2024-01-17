<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResortRequest;
use App\Models\ApartmantImage;
use App\Models\ApartmantPrice;
use App\Models\Apartment;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\City;
use App\Models\Country;
use App\Models\Resort;
use App\Models\ResortImage;
use App\Models\ResortType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ResortController extends Controller
{

    public function store(ResortRequest $request)
    {
        try {
            $request->validate([
                'priority' => 'unique:resorts,priority,NULL,id,city_id,' . $request->input('city_id'),
            ]);

            $maxPriority = Resort::where('city_id', $request->input('city_id'))->max('priority');
            $priority = ($maxPriority !== null) ? (int) $maxPriority + 1 : 1;

            $resort = Resort::create([
                'country_id' => $request->input('country_id'),
                'city_id' => $request->input('city_id'),
                'resort_type' => $request->input('resort_type'),
                'resort_name' => $request->input('resort_name'),
                'resort_description' => $request->input('resort_description'),
                'resort_location' => $request->input('resort_location'),
                'priority' => $priority,
            ]);

            // dd($request->file('image_path'));
            $resortId = $resort->id;
            if ($request->hasFile('image_path')) {
                $image = $request->file('image_path');
                $imageName = $image->store('resort_images', 'public');
            
                ResortImage::create([
                    'resort_id' => $resortId,
                    'image_path' => $imageName,
                ]);
            }

            return redirect()->route('destinations.index')->with('success', 'Resort created successfully');
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            dd($e->getMessage());
            return redirect()->back()->withErrors(['Something horribly wrong. Please try again.']);
        }
    }


    public function update(ResortRequest $request, $id)
    {
        try {
            $resort = Resort::findOrFail($id);
            
            $resort->update([
                'country_id' => $request->input('country_id'),
                'city_id' => $request->input('city_id'),
                'resort_type' => $request->input('resort_type'),
                'resort_name' => $request->input('resort_name'),
                'is_visible' => $request->input('is_visible'),
                'location' => $request->input('location'),
            ]);
    
            if ($request->hasFile('new_image')) {
                $newImage = $request->file('new_image');
                $newImagePath = $newImage->store('resort_images', 'public');
            
                if ($resort->images && $resort->images->first()) {
                    Storage::delete('public/' . $resort->images->first()->image_path);
            
                    $resort->images()->update(['image_path' => $newImagePath]);
                } else {
                    $resort->images()->create(['image_path' => $newImagePath]);
                }
            }
    
            return redirect()->route('destinations.index', $resort->id)->with('success', 'Resort updated successfully');
        } catch (\Exception $e) {
            dd($e->getMessage());
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(['Something gone wrong. Please try again.']);
        }
    }
    

    public function edit($id)
    {
        try {
            $resortTypes = ResortType::all();
            $resort = Resort::with('apartments.prices')->findOrFail($id);
            $countries = Country::all();
            $cities = City::all();
            $apartments = Apartment::all();
            $apartmentPrices = ApartmantPrice::all();
            $trashedApartments = Apartment::onlyTrashed()->where('resort_id', $id)->get();
            $apartmentImages = ApartmantImage::withTrashed()->get();

            return view('resort.edit', compact('resort', 'trashedApartments','resortTypes', 'countries', 'cities', 'apartmentPrices'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(['Something gone wrong. Please try again.']);
        }
    }

    public function softDelete($id)
    {
        try {
            $resort = Resort::findOrFail($id);
            $cityId = $resort->city_id; 
    
            $resort->delete();
    
            $this->updateResortPriorities($cityId);
    
            return redirect()->route('destinations.index')->with('success', 'Resort removed successfully');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            dd($e->getMessage());
            return redirect()->back()->withErrors(['Something went horribly wrong. Please try again.']);
        }
    }

    public function restoreResort($id)
    {
        try {
            $resort = Resort::withTrashed()->findOrFail($id);
    
            if ($resort->trashed()) {
                $cityId = $resort->city_id;
    
                $maxPriority = Resort::where('city_id', $cityId)->max('priority');
                $priority = ($maxPriority !== null) ? (int) $maxPriority + 1 : 1;
    
                // Restore the resort
                
                $resort->restore();
                $resorts = Resort::where('city_id', $cityId)->orderBy('priority')->get();
                $newPriority = 1;
                
                foreach ($resorts as $updatedResort) {
                    $updatedResort->priority = $newPriority++;
                    $updatedResort->save();
                }
    
                return redirect()->route('destinations.index')->with('success', 'Resort restored successfully.');
            } else {
                return redirect()->route('destinations.index');
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(['Something went wrong. Please try again.']);
        }
    }
    
    public function permDelete(Request $request, $id)
    {
        $moment = Resort::withTrashed()->findOrFail($id);

        $moment->forceDelete();

        return redirect()->route('destinations.index')->with('success', 'Resort deleted successfully');
           
    }

    private function updateResortPriorities($cityId)
    {
        $resorts = Resort::where('city_id', $cityId)->orderBy('priority')->get();
        $newPriority = 1;
        
        foreach ($resorts as $updatedResort) {
            $updatedResort->priority = $newPriority++;
            $updatedResort->save();
        }
    }

    public function moveUp($id)
    {
        $resort = Resort::findOrFail($id);
        $currentPriority = $resort->priority;

        if ($currentPriority > 1) {
            $previousResort = Resort::where('priority', $currentPriority - 1)
                ->where('city_id', $resort->city_id)
                ->first();

            if ($previousResort) {
                $resort->priority = $currentPriority - 1;
                $previousResort->priority = $currentPriority;

                $resort->save();
                $previousResort->save();

                $this->updateResortPriorities($resort->city_id);

                return redirect()->route('destinations.index')->with('success', 'Resort moved up successfully');
            }
        }

        return redirect()->route('destinations.index')->with('error', 'Unable to move resort up');
    }

    public function moveDown($id)
    {
        $resort = Resort::findOrFail($id);
        $currentPriority = $resort->priority;

        $maxPriority = Resort::where('city_id', $resort->city_id)->max('priority');

        if ($currentPriority < $maxPriority) {
            $nextResort = Resort::where('priority', $currentPriority + 1)
                ->where('city_id', $resort->city_id)
                ->first();

            if ($nextResort) {
                $resort->priority = $currentPriority + 1;
                $nextResort->priority = $currentPriority;

                $resort->save();
                $nextResort->save();

                $this->updateResortPriorities($resort->city_id);

                return redirect()->route('destinations.index')->with('success', 'Resort moved down successfully');
            }
        }

        return redirect()->route('destinations.index')->with('error', 'Unable to move resort down');
    }

    public function getCities($countryId)
    {
        try {
            DB::enableQueryLog(); 
            $cities = City::where('country_id', $countryId)->get();
            Log::info('SQL Query: ' . DB::getQueryLog()[0]['query']);
    
            if ($cities->isNotEmpty()) {
                return response()->json(['cities' => $cities]);
            } else {
                return response()->json(['cities' => []]);
            }
        } catch (\Exception $e) {
            Log::error('Exception: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch cities',$e->getMessage()], 500);
        }
    }

    public function updateVisibility(Request $request, $id)
    {
        try {
            $resort = Resort::findOrFail($id);
    
            $resort->is_visible = !$resort->is_visible;
            $resort->save();
    
            return redirect()->back()->with('success', 'Resort visibility updated successfully.');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Resort not found.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating resort visibility.');
        }
    }


    public function updateLastMinute(Request $request, $id)
    {
        try {
            $resort = Resort::findOrFail($id);
    
            $resort->last_minute_offer = !$resort->last_minute_offer;
            $resort->save();
    
            return redirect()->back()->with('success', 'Resort last minute status updated successfully.');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Resort not found.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating Resort last minute status.');
        }
    }
}

    

