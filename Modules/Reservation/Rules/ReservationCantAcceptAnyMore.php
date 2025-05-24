<?php

namespace Modules\Reservation\Rules;

use Illuminate\Support\Carbon;
use Illuminate\Contracts\Validation\Rule;
use Modules\Reservation\Entities\Reservation;
use Modules\Club\Repositories\Api\ClubRepository;
use Illuminate\Contracts\Validation\DataAwareRule;

class ReservationCantAcceptAnyMore implements Rule, DataAwareRule
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
        if ($this->data['action'] == 'accept') {
            return    Reservation::where('required_players', '>', 0)
                ->whereHas('requests', fn ($q) => $q->where('id', $value))->exists();
        }
        return true;
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
