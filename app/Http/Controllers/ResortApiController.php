<?php

namespace App\Http\Controllers;


use App\Models\Resort;

class ResortApiController extends Controller
{
    public function index()
    {
        $resorts = Resort::with([
            'city.country',
            'resortType',
            'images',
            'apartments' => function ($query) {
                $query->with([
                    'prices',
                    'images',
                ]);
            },
        ])->where('is_visible', true)->get();
        return response()->json($resorts, 200, [], JSON_UNESCAPED_UNICODE);

    }

}
