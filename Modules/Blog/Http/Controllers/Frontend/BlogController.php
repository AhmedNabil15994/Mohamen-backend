<?php

namespace Modules\Blog\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Route;
use Modules\Blog\Repositories\Frontend\BlogRepository as Blog;

class BlogController extends Controller
{
    public $blog;
    public function __construct(Blog $blog)
    {
        $this->blog    = $blog;
    }

    public function index()
    {
        $blogs = $this->blog->getAllBlogs();

        return view('blog::frontend.index', compact('blogs'));
    }

    public function mediaCenter()
    {
        $blogs = $this->blog->getAllMediaCenter();

        return view('blog::frontend.media_center', compact('blogs'));
    }

    public function show($slug)
    {
        $blog = $this->blog->findBySlug($slug);

        if (!checkRouteLocale($blog, $slug)) {
            return redirect()->route(Route::currentRouteName(), [$blog->slug]);
        }



        return view('blog::frontend.show', compact('blog'));
    }
}
