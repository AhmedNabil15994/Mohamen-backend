<?php

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Order\Entities\OrderCourse;

class ObtainCredential extends Model
{
    protected $table = 'obtain_credentials';
    protected $fillable = [ 'client_payload' , 'api_video_id','status'];
    public function video()
    {
        return $this->belongsTo(OrderCourse::class, 'video_link', 'api_video_id');
    }
}
