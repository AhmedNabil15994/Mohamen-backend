<div class="col-md-12">
    <div class="form-actions">
        @include('apps::dashboard.layouts._ajax-msg')
        <div class="form-group">
            <button type="submit"
                id="submit"
                class="btn btn-lg blue">
                {{__('apps::dashboard.buttons.save')}}
            </button>
            <a href="{{url(route('dashboard.clubs.index')) }}"
                class="btn btn-lg red">
                {{__('apps::dashboard.buttons.back')}}
            </a>
        </div>
    </div>
</div>
