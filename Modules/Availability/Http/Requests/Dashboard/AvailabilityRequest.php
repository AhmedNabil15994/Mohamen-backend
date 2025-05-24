<?php

namespace Modules\Availability\Http\Requests\Dashboard;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Availability\Rules\StartTimeGreaterThanEndTime;

class AvailabilityRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules = [
            'availability'                   => 'required|array',
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
