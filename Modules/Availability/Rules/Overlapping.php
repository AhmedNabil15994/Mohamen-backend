<?php

namespace Modules\Availability\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\DataAwareRule;

class Overlapping implements Rule, DataAwareRule
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

        $times = [...$value];

        $validationStatus = true;
        foreach ($times as $i => $timeA) {
            $A1 = Carbon::parse($timeA['time_from'])->format('H');
            $A2 = Carbon::parse($timeA['time_to'])->format('H');
            foreach ($times as $j => $timeB) {
                if ($i == $j) {
                    continue;
                }
                $B1 = Carbon::parse($timeB['time_from'])->format('H');
                $B2 = Carbon::parse($timeB['time_to'])->format('H');
                $overLap =  ((($B1 < $A1 and $B2 > $A1) or ($B1 > $A1 and $B1 < $A2)));

                $validationStatus = !$overLap;
            }
            if (isset($overLap)) {
                break;
            }
        }

        return $validationStatus;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('availability::dashboard.availabilities.form.overlapping');
    }
}
