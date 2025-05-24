<?php

namespace Modules\Reservation\Entities;

use Modules\Core\Traits\ScopesTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;
use Illuminate\Database\Eloquent\Builder;

class Meeting extends Model
{
    use ScopesTrait;

    protected $fillable = ['zoom_meeting_id', 'zoom_response'];

    public $casts = ['zoom_response' => SchemalessAttributes::class];


    public function meetingable()
    {
        return $this->morphTo();
    }

    public function scopeWithZoomResponse(): Builder
    {
        return $this->zoom_response->modelScope();
    }
}
