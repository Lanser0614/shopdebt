<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
        $user = request()->route('user');
        return [
            "name"     => "required|string|max:200",
            "email"    => [
                'required',
                Rule::unique('users', 'email')->ignoreModel($user),
            ],
            "password" => "nullable|string|min:8",
            "role_id"  => "required|integer"
        ];
    }
}
