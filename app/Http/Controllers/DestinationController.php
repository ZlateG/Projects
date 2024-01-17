<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\City;
use App\Models\Country;
use App\Models\Resort;
use App\Models\ResortImage;
use App\Models\ResortType;
use Illuminate\Http\Request;

class DestinationController extends Controller
{   
     public function index()
    {
        $resortTypes = ResortType::all(); 
        $countries = Country::all();
        $cities = City::all();
        $resorts = Resort::orderBy('city_id')->orderBy('priority')->get()->groupBy('city_id');
        $resorts = Resort::with('city', 'resortType', 'images')
                                ->orderBy('city_id')
                                ->orderBy('priority')
                                ->get()
                                ->groupBy('city_id');
                                
        $apartments = Apartment::with('prices')->get();

        $trashedCountries = Country::onlyTrashed()->get();
        $trashedCities = City::onlyTrashed()->get();
        $trashedResorts = Resort::onlyTrashed()->with('city', 'resortType', 'images')->get();
        $trashedImages = ResortImage::onlyTrashed()->get();
        $trashedApartments = Apartment::onlyTrashed()->with('prices')->get();
    

        return view('destinations.index', compact('countries', 'cities', 'resorts', 'apartments','trashedCountries', 'trashedCities', 'trashedResorts', 'trashedApartments','trashedImages', 'resortTypes'));
    }
}
