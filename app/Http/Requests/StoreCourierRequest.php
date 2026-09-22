<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCourierRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'email', 'max:255', 'unique:couriers,email'],
            'phone'                 => ['required', 'string', 'max:20'],
            'level'                 => ['required', 'integer', 'between:1,5'],
            'vehicle_type'          => ['nullable', 'string', 'max:50'],
            'vehicle_plate_number'  => ['nullable', 'string', 'max:20'],
            'license_number'        => ['nullable', 'string', 'max:50'],
            'address'               => ['nullable', 'string'],
            'status'                => ['nullable', 'in:active,inactive,suspended'],
            'joined_at'             => ['required', 'date'],
        ];
    }
}
