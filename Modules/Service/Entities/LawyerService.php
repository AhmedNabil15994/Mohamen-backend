<?php

namespace Modules\Service\Entities;

use Modules\Service\Entities\Service;
use Modules\Service\Enum\ServiceType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LawyerService extends Model
{

    protected $fillable = ['lawyer_id', 'service_id', 'price'];


    /**
     * Get the service that owns the LawyerService
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
