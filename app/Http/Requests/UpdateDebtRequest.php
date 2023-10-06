<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDebtRequest extends FormRequest
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
            'shop_id' => 'nullable|int|exists:shops,id',
            'client_id' => 'nullable|int|exists:clients,id',
            'comment' => 'nullable|string|max:255',
            'amount' => 'nullable|int|max_digits:7',
            'deadline' => ['nullable', 'date', 'after_or_equal:' . now()->format('Y-m-d-H')],
            'products' => 'nullable|array',
            'products.*' => 'required|int|exists:products,id'
        ];
    }
}
