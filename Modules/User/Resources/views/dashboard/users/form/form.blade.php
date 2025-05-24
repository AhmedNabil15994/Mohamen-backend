
{!! field()->text('name',__('user::dashboard.admins.create.form.name'))!!}
{!! field()->email('email',__('user::dashboard.admins.create.form.email'))!!}
{!! field()->text('mobile',__('user::dashboard.admins.create.form.mobile'))!!}
{!! field()->password('password',__('user::dashboard.admins.create.form.password'))!!}
{!! field()->password('confirm_password',__('user::dashboard.admins.create.form.confirm_password'))!!}

{!! field()->file('image',__('user::dashboard.admins.create.form.image'),$model->image?asset($model->getFirstMediaUrl('image')):'')!!}


@if ($model->trashed())
    {!! field()->checkBox('trash_restore', __('category::dashboard.categories.form.restore')) !!}
@endif
