<?php

namespace App\Http\Controllers;



use App\Models\Testimonial;

class TestimonialApiController  extends Controller
{

    public function index()
    {
        $images = Testimonial::orderBy('priority')->get();

        return response()->json($images, 200, [], JSON_UNESCAPED_UNICODE);
    }
  
}
