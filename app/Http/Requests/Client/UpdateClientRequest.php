<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
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
            'name' => 'nullable|string|max:255',
            'phone_number' => [
                'nullable',
                'regex:/^\+998(90|91|93|94|95|97|98|99|50|88|77|33|20)[0-9]{7}$/'
            ],
            'address' => 'nullable|string|max:255'
        ];
    }
}
