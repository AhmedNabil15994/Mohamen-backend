<?php

namespace Modules\Reservation\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReservationTime extends Model
{
    protected $fillable = ['reservation_id', 'from', 'to'];

    /**
     * Get the reservation that owns the ReservationTime
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }
}
