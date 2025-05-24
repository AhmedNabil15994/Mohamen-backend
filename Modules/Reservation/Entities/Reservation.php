<?php

namespace Modules\Reservation\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\ScopesTrait;
use Modules\Coupon\Entities\CouponReservation;
use Modules\Lawyer\Entities\Lawyer;
use Modules\Reservation\Entities\Meeting;
use Modules\Reservation\Entities\ReservationNotification;
use Modules\Reservation\Traits\ReservationScopes;
use Modules\Service\Entities\Service;
use Modules\Transaction\Entities\Transaction;
use Modules\User\Entities\User;

class Reservation extends Model {
  use ScopesTrait;
  use SoftDeletes;
  use ReservationScopes;
  protected $fillable = [
    'user_id', 'lawyer_id', 'date', 'extra_attributes', 'paid', 'payment_method', 'first_time', 'finish_time', 'name', 'mobile', 'service_id', 'subtotal', 'total',
  ];

  public function service(): BelongsTo {
    return $this->belongsTo(Service::class);
  }
  public function user() {
    return $this->belongsTo(User::class, 'user_id');
  }
  public function lawyer() {
    return $this->belongsTo(Lawyer::class);
  }
  public function transactions() {
    return $this->morphOne(Transaction::class, 'transaction');
  }
  public function times() {
    return $this->hasMany(ReservationTime::class, 'reservation_id');
  }
  public function coupons() {
    return $this->hasMany(CouponReservation::class, 'reservation_id');
  }

  public function meeting() {
    return $this->morphOne(Meeting::class, 'meetingable');
  }

  public function notifications() {
    return $this->hasMany(ReservationNotification::class);
  }

  public static function boot() {

    parent::boot();
    self::created(function ($model) {
      //
      $model->saveQuietly();
    });

    self::updated(function ($model) {
      //
      $model->saveQuietly();
    });

  }
}
