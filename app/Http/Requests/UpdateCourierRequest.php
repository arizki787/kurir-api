<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UpdateCourierRequest extends FormRequest
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
            'name'                  => ['sometimes', 'string', 'max:255'],
            'email'                 => [
                'sometimes',
                'email',
                'max:255',
                Rule::unique('couriers')->ignore($this->route('courier')),
            ],
            'phone'                 => ['sometimes', 'string', 'max:20'],
            'level'                 => ['sometimes', 'integer', 'between:1,5'],
            'vehicle_type'          => ['nullable', 'string', 'max:50'],
            'vehicle_plate_number'  => ['nullable', 'string', 'max:20'],
            'license_number'        => ['nullable', 'string', 'max:50'],
            'address'               => ['nullable', 'string'],
            'status'                => ['nullable', 'in:active,inactive,suspended'],
            'joined_at'             => ['sometimes', 'date'],
        ];
    }
}
