<?php

namespace App\Http\Controllers;

use App\Models\YourMoment;
use Illuminate\Http\Request;


class YourMomentApiController extends Controller
{

    public function index()
    {
        $images = YourMoment::orderBy('priority')->get();

        return response()->json($images, 200, [], JSON_UNESCAPED_UNICODE);
    }

}
