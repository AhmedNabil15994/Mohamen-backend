<?php

namespace Modules\Authorization\Repositories\Dashboard;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Authorization\Entities\Role;
use Modules\Core\Repositories\Dashboard\CrudRepository;

class RoleRepository extends CrudRepository
{
    public function __construct()
    {
        parent::__construct(Role::class);
    }

    public function getAllAdminsRoles($order = 'id', $sort = 'desc')
    {
        $roles = $this->model->whereHas('permissions', function ($query) {
            $query->where('name', 'dashboard_access');
        })->orderBy($order, $sort)->get();
        return $roles;
    }

    public function getAllLawyersRoles($order = 'id', $sort = 'desc')
    {
        $roles = $this->model->whereHas('permissions', function ($query) {
            $query->where('name', 'lawyer_access');
        })->orderBy($order, $sort)->get();
        return $roles;
    }

    public function create(Request $request)
    {
        DB::beginTransaction();

        try {
            $roleData        = $request->except('permission');

            $roleData['name']= Str::snake($roleData['display_name']['en']);

            $role = $this->model->create($roleData);
            $role->permissions()->attach($request->permission);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $role = $this->findById($id);

            $roleData = $request->except('permission');
            $roleData['name']= Str::snake($roleData['display_name']['en']);

            $role->update($roleData);
            $role->permissions()->sync($request->permission);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
