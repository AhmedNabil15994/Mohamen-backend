<?php

namespace Modules\User\Http\Requests\Api;

use Modules\User\Rule\Api\OldPasswordRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'            => 'sometimes|string',
            'image'           => 'sometimes|nullable',
            'mobile'          => 'sometimes|numeric|digits_between:8,8|unique:users,mobile,' . auth()->id() . '',
            'email'           => 'sometimes|unique:users,email,' . auth()->id() . '',
            'old_password'    => ['nullable', 'required_with:password', new OldPasswordRule()],
            'password'        => 'exclude_without:old_password|required_with:old_password|min:6|same:password_confirmation',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
