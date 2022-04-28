<?php

namespace App\Http\Requests;

use App\Exceptions\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class AccessOrganizationFolderRequest extends FormRequest
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
            'organization_folder_id' => 'bail|required|int|exists:App\Models\OrganizationFolder,id',
            'user_id' => 'bail|required|int|exists:App\Models\User,id',
            'access' => 'bail|required|string|max:1'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator);
    }
}
