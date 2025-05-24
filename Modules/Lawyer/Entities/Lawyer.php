<?php

namespace Modules\Lawyer\Entities;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Core\Traits\ScopesTrait;
use Modules\Service\Entities\Service;
use Spatie\Permission\Traits\HasRoles;
use Modules\Category\Entities\Category;
use Illuminate\Notifications\Notifiable;
use Modules\Lawyer\Traits\LawyerHelpers;
use Modules\Availability\Entities\Vacation;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Reservation\Entities\Reservation;
use Modules\Availability\Entities\Availability;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Lawyer extends Authenticatable implements HasMedia
{
    use Notifiable;
    use ScopesTrait;
    use HasRoles;
    use HasFactory;
    use InteractsWithMedia;
    use LawyerHelpers;

    use SoftDeletes {
        restore as private restoreB;
    }

    protected $guard_name = 'web';
    protected $morphClass = 'user';


    protected $table = 'users';

    protected $dates = [
        'deleted_at'
    ];

    protected $fillable = [
        'name', 'email', 'password', 'mobile', 'image', 'mobile_code','uid'
    ];


    public function getMorphClass()
    {
        return 'Modules\User\Entities\User';
    }


    protected $hidden = [
        'password', 'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function restore()
    {
        $this->restoreB();
    }

    public function profile()
    {
        return $this->hasOne(LawyerProfile::class);
    }

    /**
     * The services that belong to the Lawyer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(
            Service::class,
            'lawyer_services',
            'lawyer_id',
            'service_id'
        )->withPivot(['price']);
    }
    public function setPasswordAttribute($value)
    {
        if ($value === null || !is_string($value)) {
            return;
        }
        $this->attributes['password'] = Hash::needsRehash($value) ? Hash::make($value) : $value;
    }

    public function categories()
    {
        return $this->morphToMany(Category::class, 'categorized', 'categorized');
    }

    public function availabilities()
    {
        return $this->morphMany(Availability::class, 'available');
    }




    public function vacation()
    {
        return $this->morphOne(Vacation::class, 'vacationable');
    }








    protected static function booted()
    {
        static::addGlobalScope('lawyers', function ($query) {
            $query->whereHas('roles.permissions', function ($query) {
                $query->where('name', 'lawyer_access');
            });
        });
    }







    public function scopeFilterApi($query)
    {
        return $query
            ->when(
                request()->category_id,
                fn ($q, $val) => $q->whereRelation('categories', 'categorized.category_id', '=', $val)
            )->search();
    }
    public function scopeSearch($query)
    {
        return $query
            ->when(
                request()->search,
                function ($q, $val) {
                    $q->where('name', $val);
                    foreach (config('translatable.locales') as $code) {
                        $q->orWhereRelation(
                            'categories',
                            "categories.title->$code",
                            '=',
                            $val
                        )->orWhereRelation(
                            'services',
                            "services.title->$code",
                            '=',
                            $val
                        );
                    }
                    return $q;
                }
            );
    }

    public function scopeWithTotalReservationPrice($query)
    {
        return  $query
            ->withCount(['reservations as totalPrice' => function ($q) {
                $q->select(
                    DB::raw('IFNULL(sum(reservations.total),0) as totalPrice'),
                )->datatableDataRange();
            }])
            ->withCount(['reservations as totalCount' => function ($q) {
                $q->select(
                    DB::raw('IFNULL(count(reservations.id), 0)  as totalCount')
                )->datatableDataRange();
            }]);
    }

    /**
     * Get all of the reservations for the Club
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class, 'lawyer_id');
    }
}
