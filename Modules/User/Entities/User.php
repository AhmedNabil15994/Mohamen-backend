<?php

namespace Modules\User\Entities;

use Modules\Level\Entities\Level;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Modules\Core\Traits\ScopesTrait;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Modules\Core\Traits\Dashboard\CrudModel;
use Modules\DeviceToken\Traits\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Reservation\Entities\Reservation;
use Modules\Notification\Entities\GeneralNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Reservation\Entities\ReservationJoinRequest;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Reservation\Entities\ReservationPlayer;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class User extends Authenticatable implements HasMedia,\Tocaan\FcmFirebase\Contracts\IFcmFirebaseDevice
{
    use CrudModel {
        __construct as private CrudConstruct;
    }

    use HasJsonRelationships;
    use \Tocaan\FcmFirebase\Traits\FcmDeviceTrait;


    use HasRoles;
    use InteractsWithMedia;
    use HasApiTokens;
    use Notifiable;

    use SoftDeletes {
        restore as private restoreB;
    }
    protected $guard_name = 'web';

    protected $dates = [
        'deleted_at'
    ];

    protected $fillable = [
        'name', 'email', 'password', 'mobile', 'image', 'status', 'profile', 'mobile_code','uid','level_id'
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setLogAttributes(['name', 'email', 'password', 'mobile', 'image']);
    }


    public function setPasswordAttribute($value)
    {
        if ($value === null || !is_string($value)) {
            return;
        }
        $this->attributes['password'] = Hash::needsRehash($value) ? Hash::make($value) : $value;
    }

    public function restore()
    {
        $this->restoreB();
    }

    public function scopeNormalUser(Builder $query): Builder
    {
        return $query->whereDoesntHave('roles');
    }
    public function scopeAdminUser(Builder $query): Builder
    {
        return $query->whereHas('roles.permissions', function ($query) {
            $query->where('name', 'dashboard_access');
        });
    }

    public function scopeWithProfile(): Builder
    {
        return $this->profile->modelScope();
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function fcmTokens()
    {
        return $this->hasMany(FirebaseToken::class);
    }
    public function notifications()
    {
        return $this->morphMany(GeneralNotification::class, 'notifiable');
    }
}
