<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:100'],
            'type'        => ['required', 'string', 'max:50'],
            'breed'       => ['nullable', 'string', 'max:100'],
            'age'         => ['nullable', 'integer', 'min:0', 'max:100'],
            'gender'      => ['required', 'in:male,female,unknown'],
            'status'      => ['required', 'in:available,adopted,pending'],
            'description' => ['nullable', 'string', 'max:1000'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }
}
