<?php

namespace Modules\Category\Repositories\Api;

use Modules\Category\Entities\Category;
use Modules\Core\Repositories\Api\ApiCrudRepository;

class CategoryRepository extends ApiCrudRepository
{
    function __construct(Category $category)
    {
        parent::__construct($category);
    }



    public function getModel()
    {
        $model = parent::getModel()->orderBy('order','asc');

        return $model
            ->when(request()->has('has_courses'), function ($query) {
                return $query->whereHas('courses');
            });
    }
}
