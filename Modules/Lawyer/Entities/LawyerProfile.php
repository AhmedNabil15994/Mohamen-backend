<?php

namespace Modules\Lawyer\Entities;

use Modules\Area\Entities\City;
use Modules\Core\Traits\ScopesTrait;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LawyerProfile extends Model
{
    use HasTranslations;
    use ScopesTrait;

    protected $table = 'lawyer_profile';
    protected $fillable = [
        'facebook',
        'linkedin',
        'twitter',
        'instagram',
        'youtube',
        'status',
        'lawyer_id',
        'about',
        'job_title',
        'country',
        'city_id',
    ];

    public $translatable     = ['about', 'job_title', 'country'];




    /**
     * Get the city that owns the LawyerProfile
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
