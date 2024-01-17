<?php

namespace App\Http\Controllers;

use App\Http\Requests\CountryRequest;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class CountryController extends Controller
{


    public function store(CountryRequest $request)
    {
        try {
            Country::create([
                'country_name' => $request->input('country_name'),
            ]);

            return Redirect::route('destinations.index')->with('success', 'Country added successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessage = $e->validator->errors()->first();

            return Redirect::back()->withErrors([$errorMessage])->withInput();
        } catch (\Exception $e) {
            // Log the error
            Log::error($e->getMessage());

            return Redirect::back()->withErrors([$e->getMessage()])->withInput();
        }
    }


    public function edit($id)
    {
        try {
            $country = Country::findOrFail($id);
            return view('countries.edit', compact('country'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(['Something went wrong. Please try again.']);
        }
    }
    
    
    public function update($id, CountryRequest $request)
    {
        try {
            $country = Country::findOrFail($id);
    
            $this->validate(request(), [
                'country_name' => [
                    'required',
                    'string',
                    Rule::unique('countries', 'country_name')->ignore($country->id),
                ],
            ]);
    
            $country->update([
                'country_name' => $request->input('country_name'),
            ]);
    
            return redirect()->route('destinations.index')->with('success', 'Country updated successfully');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(['Something went wrong. Please try again.']);
        }
    }
    
    public function softDelete($id)
    {
        try {
            $country = Country::findOrFail($id);
            $country->delete();

            return redirect()->route('destinations.index')->with('success', 'Country soft deleted successfully');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            dd($e->getMessage());
            return redirect()->back()->withErrors(['Something went horribly and wrong. Please try again.']);
        }
    }


    public function restoreCountry($id)
    {
        $testemonial = Country::withTrashed()->findOrFail($id);

        if ($testemonial->trashed()) {
            $testemonial->restore();
            return redirect()->route('destinations.index')->with('success', 'Country restored successfully.');
        } else {
            return redirect()->route('destinations.index');
        }
    }
}
