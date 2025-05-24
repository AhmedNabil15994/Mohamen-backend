<div class="col-md-3">
    <div class="categories-side">
        <div class="accordion"
            id="accordionExample">
            <div class="panel-head"
                data-toggle="collapse"
                data-target="#collapse1"
                aria-expanded="true"
                aria-controls="collapse1">
                <h4> {{ __('English Language') }}</h4>
                <span class="colles-block"></span>
            </div>
            <div class="widget-content collapse show"
                id="collapse1"
                aria-labelledby="heading1"
                data-parent="#accordionExample">
                <ul class="categories-content">
                    <li class="cat-item active"><a href="#">{{ __('All') }}</a></li>
                    @foreach($mainCategories as $key => $category)


                    <li class="has-child arrow-sub cat-item cat-parent
                     {{
 $category->id==optional($currentCategory)->id|| $category->id==optional(optional($currentCategory)->parent)->id?'show-sub':''
                     }}">
                        <a
                            href="{{ route('frontend.courses',['category_id'=>$category->id,request()->has('live_courses')?'live_courses':'']) }}">
                            {{ $category->title }}
                        </a><span class="arrow-cate"></span>
                        <ul class="children">
                            @foreach($category->children as $key => $child)
                            <li class="cat-item"><a
                                    href="{{ route('frontend.courses',['category_id'=>$child->id,request()->has('live_courses')?'live_courses':'']) }}">{{
                                    $child->title
                                    }}</a></li>
                            @endforeach
                        </ul>
                    </li>


                    @endforeach

                </ul>
            </div>
        </div>

    </div>
</div>
