<?php

namespace App\Http\Requests\User;

use App\Constants\AppConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')],
            'password' => ['required', 'string', 'min:8', 'alpha_num'],
            'mobile' => ['required', 'numeric', 'digits:10'],
            'dob' => ['required', 'date'],
            'gender' => ['required', 'in:Male,Female'],
            'status' => ['nullable', 'in:' . AppConstants::USER_ACTIVE . ',' . AppConstants::USER_INACTIVE],

        ];
    }
}
