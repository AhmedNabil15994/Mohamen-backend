<?php

namespace Modules\Availability\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\DataAwareRule;

class StartTimeGreaterThanEndTime implements Rule, DataAwareRule
{

    /**
     * All of the data under validation.
     *
     * @var array
     */
    protected $data = [];


    /**
     * Set the data under validation.
     *
     * @param  array  $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }



    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $end = data_get(
            $this->data,
            str_replace('time_from', 'time_to', $attribute)
        );
        return (Carbon::parse($value)->lessThan(Carbon::parse($end)));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('availability::dashboard.availabilities.form.time_greater_than');
    }
}
