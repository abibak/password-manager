<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\ValidationException;

class UserLoginRequest extends FormRequest
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
            'user_folder_id' => 'exists:App\Models\UserFolder,id',
            'name' => 'bail|required|min:3|max:100',
            'login' => 'bail|required|max:150',
            'password' => 'bail|required',
            'note' => 'bail|max:500',
            'tag' => 'bail|max:50',
            'url' => 'bail|max:200',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator);
    }
}