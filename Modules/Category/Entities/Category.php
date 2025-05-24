<?php

namespace Modules\Category\Entities;

use Spatie\MediaLibrary\HasMedia;
use Modules\Course\Entities\Course;
use Modules\Lawyer\Entities\Lawyer;
use Modules\Core\Traits\ScopesTrait;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\InteractsWithMedia;
use Modules\Core\Traits\Dashboard\CrudModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model implements HasMedia
{
    use CrudModel, SoftDeletes, HasTranslations, InteractsWithMedia, ScopesTrait;

    protected $fillable = ['status', 'type', 'category_id', 'title', 'order'];
    public $translatable = ['title'];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'category_id');
    }

    public function getParentsAttribute()
    {
        $parents = collect([]);

        $parent = $this->parent;

        while (!is_null($parent)) {
            $parents->push($parent);
            $parent = $parent->parent;
        }

        return $parents;
    }
    public function scopeMainCategories($query)
    {
        return $query->where('category_id', '=', null);
    }
    public function courses()
    {
        return $this->hasMany(Course::class);
    }







   
}
