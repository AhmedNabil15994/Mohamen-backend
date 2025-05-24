<?php

namespace Modules\Reservation\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReservationNotification extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
}
