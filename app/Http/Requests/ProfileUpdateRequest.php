<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        if ($this->filled('phone')) {
            $digits = preg_replace('/[^0-9]/', '', $this->phone);

            if (str_starts_with($digits, '0')) {
                $digits = '62'.substr($digits, 1);
            }

            $this->merge(['phone' => $digits]);
        }
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'phone' => ['required', 'string', 'min:10', 'max:20'],
        ];
    }
}
