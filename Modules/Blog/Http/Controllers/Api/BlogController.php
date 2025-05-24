<?php

namespace Modules\Blog\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Blog\Transformers\Api\BlogResource;
use Modules\Blog\Repositories\Api\BlogRepository as Blog;
use Modules\Apps\Http\Controllers\Api\ApiController;

class BlogController extends ApiController
{
    public $blogs;
    public function __construct(Blog $blogs)
    {
        $this->blogs = $blogs;
    }

    public function index(Request $request)
    {
        $blogs =  $this->blogs->getPagination($request);
        return  BlogResource::collection($blogs);
    }
}
