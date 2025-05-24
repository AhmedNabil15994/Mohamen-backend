<?php

namespace Modules\Level\Entities;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\HasTranslations;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;

class Level extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasTranslations;
    use SoftDeletes;

    public $fillable = ['title','winning_count'];
    public $translatable = ['title'];
}
