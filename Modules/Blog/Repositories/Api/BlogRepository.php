<?php

namespace Modules\Blog\Repositories\Api;


use Modules\Blog\Entities\Blog;
use Modules\Core\Repositories\Api\ApiCrudRepository;

class BlogRepository extends ApiCrudRepository
{
    public function __construct()
    {
        parent::__construct(Blog::class);
    }
}
