<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'name'           => ['required', 'string', 'max:100'],
            'clinic'         => ['required', 'string', 'max:150'],
            'email'          => ['nullable', 'email', 'max:100'],
            'phone'          => ['nullable', 'string', 'max:20'],
            'specialization' => ['nullable', 'string', 'max:100'],
        ];
    }
}
