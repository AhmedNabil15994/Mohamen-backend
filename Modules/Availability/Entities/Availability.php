<?php

namespace Modules\Availability\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class Availability extends Model
{
    use ScopesTrait;
    protected $fillable = [
        'available_id', 'day_code', 'status', 'custom_times', 'price', 'available_type', 'is_full_day'
    ];

    protected $casts = [
        "custom_times" => "array"
    ];


    public function available()
    {
        return $this->morphTo();
    }


    public function scopeModelAndDay(Builder $query, $id, $day_code,  $model)
    {
        $queryParams = [
            'available_type' => app($model)->getMorphClass(),
            'available_id' => $id, 'day_code' =>  $day_code
        ];
        return $query->where($queryParams);
    }
}
