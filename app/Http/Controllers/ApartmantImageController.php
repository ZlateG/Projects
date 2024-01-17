<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApartmentImagesRequest;
use App\Models\ApartmantImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class ApartmantImageController extends Controller
{
    public function store(ApartmentImagesRequest $request)
    {

        try {
            $apartmantId = $request->apartmant_id;
            $images = $request->file('images');

            foreach ($images as $image) {
                // Store each image in the storage and get its path
                $imagePath = $image->store('apartmant_images', 'public');

                ApartmantImage::create([
                    'apartmant_id' => $apartmantId,
                    'image_path' => $imagePath,
                ]);
            }

            return redirect()->back()->with('success', 'Images uploaded successfully.');
        } catch (\Exception $e) {
            // Log the exception for further investigation
            Log::error($e->getMessage());
            dd($e->getMessage());

            return redirect()->back()->with('error', 'Failed to upload images. Please try again.');
        }
    }


 
    public function destroy($id)
    {
        try {
            $image = ApartmantImage::findOrFail($id);

            Storage::delete('public/' . $image->image_path);

            $image->delete();

            return Response::json(['success' => true], 200);
        } catch (\Exception $e) {
            return Response::json(['error' => 'Failed to delete image.'], 500);
        }
    }

    

}
