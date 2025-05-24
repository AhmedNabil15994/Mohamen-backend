<?php

namespace Modules\User\Http\Requests\Api;

use Illuminate\Validation\Rule;
use Modules\User\Rule\Api\OldPasswordRule;
use Illuminate\Foundation\Http\FormRequest;

class FCMTokenRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firebase_token' => 'required',
            'device_type'    => 'required|in:ios,android,desktop',
            'lang'           => 'required|in:ar,en',
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function validated()
    {
        $data = $this->validator->validated();
        $data['user_id'] = auth('sanctum')->id() ?? request()->user_id;
        return $data;
    }
}
