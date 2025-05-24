<?php

namespace Modules\Service\Entities;

use Spatie\Sluggable\SlugOptions;
use Modules\Core\Traits\ScopesTrait;
use Modules\Trainer\Entities\Trainer;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\HasTranslations;
use Modules\Core\Traits\HasSlugTranslation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class Service extends Model implements HasMedia
{
    use HasTranslations;
    use ScopesTrait;
    use SoftDeletes;
    use HasSlugTranslation;
    use InteractsWithMedia;

    protected $fillable = ['status', 'desc', 'title', 'slug', 'type'];
    public $translatable = ['desc', 'title', 'slug'];
    public $sluggable    = 'title';

    //call text video
}
