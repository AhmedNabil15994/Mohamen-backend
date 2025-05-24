<?php

namespace Modules\Reservation\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 *
 */
trait ReservationScopes
{
    public function scopeLawyerAndDate($query, $lawyer_id, $date)
    {
        return  $query->where(['lawyer_id' => $lawyer_id, 'date' => $date]);
    }
    public function scopeLawyerOwner($query)
    {
        return  $query->whereHas('lawyer', fn ($q) => $q->where('owner_id', auth()->id()));
    }
    public function scopePaid($query)
    {
        return  $query->where('paid', 'paid');
    }

    public function scopeFilterDateTime($query)
    {
        $request = request()->all();
        $date = data_get($request, 'date');
        $time = data_get($request, 'time');
        return $query->when(
            $date && $time,
            fn (Builder $q) => $q->where('date', $date)->whereHas(
                'times',
                fn ($q) => $q->where(['from' => data_get($time, 'from'), 'to' => data_get($time, 'to')])
            )
        );
    }
    public function scopeFilterState($query)
    {
        $state = data_get(request(), 'state');
        return $query
            ->when($state, function ($query) use ($state) {
                $query->whereHas('lawyer', fn ($q) => $q->where('state_id', $state));
            });
    }
    public function scopeFilterRequiredPlayers($query)
    {
        $requiredPlayers = data_get(request(), 'required_players');
        return $query
            ->when($requiredPlayers, function ($query) use ($requiredPlayers) {
                $query->where('required_players', $requiredPlayers);
            });
    }
}
