<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApartmentRequest;
use App\Models\ApartmantPrice;
use App\Models\Apartment;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApartmentController extends Controller
{
    public function store(ApartmentRequest $request)
    {
        try {
            Apartment::create([
                'apartment_name' => $request->input('apartment_name'),
                'apartment_description' => $request->input('apartment_description'),
                'resort_id' => $request->input('resort_id'),
            ]);
        
            return redirect()->back()->with('success', 'Apartment created successfully');
        } catch (QueryException $e) {
            // Handle the exception, you can log the error, redirect to an error page, or show an error message
            return redirect()->back()->with('error', 'Apartment creation failed: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $apartment = Apartment::with(['prices', 'resort'])->findOrFail($id);
        $prices = $apartment->prices;
    
    
        return view('apartments.edit', compact('apartment', 'prices'));
    }
   

    public function softDelete($id)
    {
        try {
            $apartment = Apartment::findOrFail($id);
    
            $apartment->delete();
            return redirect()->back()->with('success', 'Apartment removed successfully');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(['Something went horribly wrong. Please try again.']);
        }
    }

    public function restoreApartment($id)
    {
        try {
            $apartment = Apartment::withTrashed()->findOrFail($id);
    
            
            $apartment->restore();
            
            return redirect()->back()->with('success', 'Apartment restored successfully');

      } 
         catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(['Something went wrong. Please try again.']);
        }
    }
    
    public function permDelete(Request $request, $id)
    {
        $apartment = Apartment::onlyTrashed()->findOrFail($id);

        $apartment->forceDelete();

        return redirect()->back()->with('success', 'Apartment removed successfully');   
    }

    public function update(ApartmentRequest $request, $id)
    {
        try {
            $apartment = Apartment::findOrFail($id);
    
            $apartment->update([
                'apartment_name' => $request->input('apartment_name'),
                'apartment_description' => $request->input('apartment_description'),
            ]);
    
            // Update Prices
            $pricesData = $request->input('prices', []);
    
            foreach ($pricesData as $priceIndex => $priceAttributes) {
                // Find the price by index or create a new one
                $price = isset($priceAttributes['id'])
                    ? ApartmantPrice::findOrFail($priceAttributes['id'])
                    : new ApartmantPrice();
    
                // Update or create the price
                $price->update([
                    'price' => $priceAttributes['price'],
                    'start_date' => $priceAttributes['start_date'],
                    'end_date' => $priceAttributes['end_date'],
                ]);
    
                // Associate the price with the apartment
                $apartment->prices()->save($price);
            }
    
            return redirect()->back()->with('success', 'Apartment and prices updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating the apartment and prices');
        }
    }

    public function updatePrices(Request $request, $id)
    {
        return app(ApartmantPriceController::class)->update($request, $id);
    }
}
