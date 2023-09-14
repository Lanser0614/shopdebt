<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDebtRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'shop_id' => 'required|int|exists:shops,id',
            'client_id' => 'required|int|exists:clients,id',
            'comment' => 'required|string|max:255',
            'amount' => 'required|int|digits:7',
            'deadline' => ['nullable', 'date', 'after_or_equal:' . now()->format('Y-m-d-H-i')]
        ];
    }
}
