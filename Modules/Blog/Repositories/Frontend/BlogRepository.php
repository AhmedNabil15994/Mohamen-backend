<?php

namespace Modules\Blog\Repositories\Frontend;

use Modules\Blog\Entities\Blog;

class BlogRepository
{
    public function __construct(Blog $blog)
    {
        $this->blog   = $blog;
    }

    public function getAllBlogs($order = 'id', $sort = 'desc')
    {
        $blogs = $this->blog->active()->orderBy($order, $sort)->paginate(24);

        return $blogs;
    }

    public function getLimitedBlogs($order = 'id', $sort = 'desc')
    {
        $blogs = $this->blog->active()->where('is_news', 0)->latest()->take(10)->get();

        return $blogs;
    }

    public function getAllMediaCenter($order = 'id', $sort = 'desc')
    {
        $blogs = $this->blog->active()->where('is_news', 1)->orderBy($order, $sort)->paginate(24);

        return $blogs;
    }

    public function findBySlug($slug)
    {
        return $this->blog->active()
                     ->anyTranslation('slug', $slug)->firstOrFail();
    }
}
