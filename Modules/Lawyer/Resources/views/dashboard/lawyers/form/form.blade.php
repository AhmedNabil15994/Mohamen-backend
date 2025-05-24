@inject('roles', 'Modules\Authorization\Repositories\Dashboard\RoleRepository')

{!! field()->text('name', __('lawyer::dashboard.lawyers.create.form.name')) !!}
{!! field()->email('email', __('lawyer::dashboard.lawyers.create.form.email')) !!}
{!! field()->text('mobile', __('lawyer::dashboard.lawyers.create.form.mobile')) !!}
{!! field()->password('password', __('lawyer::dashboard.lawyers.create.form.password'),
['autocomplete'=>"new-password"]
) !!}
{!! field()->password('confirm_password', __('lawyer::dashboard.lawyers.create.form.confirm_password')) !!}
{!! field()->file('image', __('lawyer::dashboard.lawyers.create.form.image'),
$model ? $model->getFirstMediaUrl('images') : '') !!}
{!!
field()->select('categories[]',__('course::dashboard.courses.form.tabs.categories'),$extraData['categories'],$model->categories,['multiple'=>'multiple','data-name'=>'categories']
) !!}
<div class="form-group">
  <label class="col-md-2">
    {{ __('lawyer::dashboard.lawyers.create.form.roles') }}
  </label>
  <div class="col-md-9">
    <div class="mt-checkbox-list">
      @foreach ($roles->getAllLawyersRoles('id', 'asc') as $role)
      <label class="mt-checkbox">
        <input type="checkbox"
          name="roles[]"
          @if($model->hasRole($role->name)) checked @endif
        value="{{ $role->id }}">
        {{ $role->display_name }}
        <span></span>
      </label>
      @endforeach
    </div>
  </div>
</div>


@if ($model->trashed())
{!! field()->checkBox('trash_restore', __('page::dashboard.pages.form.restore')) !!}
@endif
