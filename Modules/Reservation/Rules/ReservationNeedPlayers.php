<?php

namespace Modules\Reservation\Rules;


use Illuminate\Contracts\Validation\Rule;

use Modules\Reservation\Entities\Reservation;

use Illuminate\Contracts\Validation\DataAwareRule;

class ReservationNeedPlayers implements Rule, DataAwareRule
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
        return Reservation::where('required_players', '>', 0)->where('id', $value)->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('reservation::api.message.error_need_player');
    }
}
