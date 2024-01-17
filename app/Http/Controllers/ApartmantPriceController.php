<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApartmentPriceRequest;
use App\Models\ApartmantPrice;
use App\Models\Apartment;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ApartmantPriceController extends Controller
{


    public function update(ApartmentPriceRequest $request, $priceId)
    {
        try {
            $price = ApartmantPrice::findOrFail($priceId);
    
            // Update the price
            $price->update([
                'price' => $request->input('price'),
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
            ]);
    
            return redirect()->back()->with('success', 'Price updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating the price');
        }
    }
    
    public function store(ApartmentPriceRequest $request)
    {
        try {
            $apartmentPrice = ApartmantPrice::create([

                'apartmant_id' => $request->input('apartmant_id'),
                'price' => $request->input('price'),
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
            ]);
        
            return redirect()->back()->with('success', 'Date / Prices successfully created.');
        } catch (QueryException $e) {
        
            return redirect()->back()->with('error', 'Date / Prices creation failed: ');
        }
    }
    

    public function destroy($priceId)
    {
        $price = ApartmantPrice::findOrFail($priceId);
        $price->forceDelete();

        return response()->json(['message' => 'Price deleted successfullyyyyy']);    }
}
