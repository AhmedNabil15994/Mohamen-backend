<?php

namespace Modules\Lawyer\Http\Requests\Dashboard;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Availability\Rules\{
    Overlapping,
    StartTimeGreaterThanEndTime
};

class LawyerRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'roles'                          => 'required',
            'name'                           => 'required',
            'mobile'                         => 'required|numeric|unique:users,mobile|digits_between:8,8',
            'email'                          => 'required|unique:users,email',
            'password'                       => 'required|min:6|same:confirm_password',
            'categories'                     => 'required|array',
            'categories.*'                   => 'required|exists:categories,id',
            'availability'                   => 'required|array',
            'availability.*.times'         => [new Overlapping],
            'availability.*.times.*'         => ['nullable', 'sometimes'],
            'availability.*.times.*.time_from' =>
            [
                new StartTimeGreaterThanEndTime(),
                'required_with:availability.*.times.time_to',
            ],
            'availability.*.times.*.time_to'   => [
                'required_with:availability.*.times.*.time_from'
            ],
        ];
        if ($this->isMethod('PUT')) {
            $rules['mobile']     = 'required|numeric|digits_between:8,8|unique:users,mobile,' . $this->lawyer . ',id';
            $rules['email']      = 'required|unique:users,email,' . $this->lawyer . ',id';
            $rules['password']   = 'nullable|min:6|same:confirm_password';
        }
        return $rules;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
