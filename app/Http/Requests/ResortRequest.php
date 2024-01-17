<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResortRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'resort_type' => 'required|exists:resort_types,id',
            'resort_name' => 'required|string|max:255',
            'resort_description' => 'required|string|max:255',
        ];
    }
}
