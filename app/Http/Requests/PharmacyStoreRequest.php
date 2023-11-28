<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PharmacyStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'max:255', 'string'],
            'admin_id' => ['required', 'max:255'],
            'clinic_id'=>['required'],
            'store_id'=>['required'],
            // 'campus_id' => ['required', 'exists:campus,id'],
            'status' => ['required', 'boolean'],
            'description' => ['required', 'max:255', 'string'],
        ];
    }
}
