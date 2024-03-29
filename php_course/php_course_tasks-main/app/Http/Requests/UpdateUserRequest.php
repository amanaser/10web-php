<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
    public function rules(): array
    {
        return
            [
                'first_name' => 'required|string|min:3|max:255',
                'last_name' => 'required|string|min:3|max:255',
                'email' => [
                    'required',
                    'email:rfc',
                    Rule::unique('users')->ignore($this->id),
                ],
//                'username' => [
//                    'required',
//                    'string',
//                    'min:3',
//                    'max:255',
//                    Rule::unique('users','username')->ignore($this->id),
//                ],
                'gender' => 'required:in:male,female',
                'current_password' => 'required_with:new_password|current_password:api',
                'new_password' => 'nullable|different:current_password|confirmed|string|min:3|max:255'
            ];
    }

    public function messages()
    {
        return [
            'new_password.different'    => ':attribute must be different than current one'
        ];
    }

    public function attributes()
    {
        return [
            'new_password' => 'your new password'
        ];
    }
}
