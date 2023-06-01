<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VenueUpdateRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'notes' => ['required', 'string'],
            'street_address' => ['required', 'string'],
            'city' => ['required', 'string'],
            'maximum_stage_width' => ['required', 'integer', 'gt:0'],
            'maximum_stage_depth' => ['required', 'integer', 'gt:0'],
            'maximum_stage_height' => ['required', 'integer', 'gt:0'],
            'maximum_seats' => ['required', 'integer', 'gt:0'],
            'maximum_wheelchair_seats' => ['required', 'integer', 'gt:0'],
            'number_of_dressing_rooms' => ['required', 'integer', 'gt:0'],
            'backstage_wheelchair_access' => ['required'],
        ];
    }
}
