<?php

namespace App\Http\Requests;

use App\Exceptions\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class OrganizationLoginRequest extends FormRequest
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
            'organization_folder_id' => 'required',
            'name' => 'bail|required|max:100',
            'login' => 'bail|required|max:150',
            'password' => 'bail|required|min:6|max:60',
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
