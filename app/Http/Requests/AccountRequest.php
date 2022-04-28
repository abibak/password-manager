<?php

namespace App\Http\Requests;

use App\Exceptions\ValidationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class AccountRequest extends FormRequest
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
            'login' => 'bail|required|string|min:3|max:40',
            'email' => 'bail|string|required',
            'email_notification' => 'bail|required',
            'auto_logout' => 'bail|required',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator);
    }
}
