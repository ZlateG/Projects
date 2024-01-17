<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\CityRequest;

class CityController extends Controller
{

    public function store(CityRequest $request)
    {
        try {
            City::create([
                'city_name' => $request->input('city_name'),
                'country_id' => $request->input('country_id'),
            ]);
    
            return redirect()->route('destinations.index')->with('success', 'City added successfully');
        } catch (\Exception $e) {

            Log::error($e->getMessage());
    
            return redirect()->back()->withErrors([$e->getMessage()])->withInput();
        }
    }

    public function edit($id)
    {
        try {

            $countries = Country::all();
            $city = City::findOrFail($id);
            $country = Country::findOrFail($city->country_id);
            return view('cities.edit', compact('city', 'countries','country',));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(['Something went wrong. Please try again.']);
        }
    }

    public function update($id, CityRequest $request)
    {
        try {
            $city = City::findOrFail($id);
    
            $this->validate($request, [
                'city_name' => [
                    'required',
                    'string',
                    Rule::unique('cities', 'city_name')->ignore($city->id),
                ],
            ]);
    
            $city->update([
                'city_name' => $request->input('city_name'),
                'country_id' => $request->input('country_id'),
            ]);
    
            return redirect()->route('destinations.index')->with('success', 'City updated successfully');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(['Something went horribly wrong. Please try again.']);
        }
    }
    
    public function softDelete($id)
    {
        try {
            $country = City::findOrFail($id);
            $country->delete();

            return redirect()->route('destinations.index')->with('success', 'City removed successfully');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            dd($e->getMessage());
            return redirect()->back()->withErrors(['Something went wrong. Please try again.']);
        }
    }

    public function restoreCity($id)
    {
        $testemonial = City::withTrashed()->findOrFail($id);

        if ($testemonial->trashed()) {
            $testemonial->restore();
            return redirect()->route('destinations.index')->with('success', 'City restored successfully.');
        } else {
            return redirect()->route('destinations.index');
        }
    }
}
