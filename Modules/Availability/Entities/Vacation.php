<?php

namespace Modules\Availability\Entities;

use Modules\Lawyer\Entities\Lawyer;
use Modules\Core\Traits\ScopesTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vacation extends Model
{

    use ScopesTrait;

    protected $fillable = [
        'weekly_vacations', 'date_ranges', 'vacationable_id','vacationable_type'
    ];


    public $casts = [
        'weekly_vacations' => 'array',
        'date_ranges' => 'array'
    ];
}
