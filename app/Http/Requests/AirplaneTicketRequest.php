<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AirplaneTicketRequest extends FormRequest
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
                'ticket_type' => 'required|string',
                'from_destination' => 'required|string|max:255',
                'to_destination' => 'required|string|max:255',
                'departure_date' => 'required|string|max:255',
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'message' => 'required|string',
        ];
    }
}
