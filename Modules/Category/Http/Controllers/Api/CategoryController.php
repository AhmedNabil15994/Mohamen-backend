<?php

namespace Modules\Category\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Category\Transformers\Api\CategoryResource;
use Modules\Category\Repositories\Api\CategoryRepository as Category;

class CategoryController extends ApiController
{
    public $category;
    function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function index(Request $request)
    {
        $categories =  $this->category->getAll();

        return CategoryResource::collection($categories);
    }
}
