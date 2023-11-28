<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrescriptionStoreRequest extends FormRequest
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

            'drug_name' => ['nullable', 'max:255', 'string'],
            'dose' => ['nullable', 'max:255', 'string'],
            'frequency' => ['nullable', 'max:255', 'string'],
            'duration' => ['nullable', 'max:255', 'string'],

            'other_info' => ['nullable', 'max:255', 'string'],
            'main_diagnosis_id' => ['nullable', 'exists:main_diagnoses,id'],
            'location_of_medication' => ['required'],
            'items_in_pharmacies_id' => ['nullable'],
            'encounter_id' => ['required'],
            'clinic_id' => ['required'],
        ];
    }
}
