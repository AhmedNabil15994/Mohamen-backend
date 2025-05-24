<?php

namespace Modules\Blog\ViewComposers\Frontend;

use Modules\Blog\Repositories\Frontend\BlogRepository as Blog;
use Illuminate\View\View;
use Cache;

class BlogComposer
{
    public function __construct(Blog $blog)
    {
        $this->blogs =  $blog->getLimitedBlogs();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('blogs', $this->blogs);
    }
}
