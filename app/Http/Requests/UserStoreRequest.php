<?php

namespace App\Http\Requests;

use App\Exceptions\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'login' => 'bail|required|string|min:2|max:40|unique:users,login',
            'email' => 'bail|required|string|unique:users,email',
            'role_id' => 'bail|required|integer|exists:roles,id',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        return throw new ValidationException($validator);
    }
}
