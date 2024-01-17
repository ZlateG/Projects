<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApartmentImagesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [ 
            'apartmant_id' => 'required|exists:apartments,id',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif', 
        ];
    }
}
