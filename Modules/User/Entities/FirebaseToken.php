<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;

class FirebaseToken extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_id', 'device_token', 'platform','lang'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
