<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Role\Permission;
use App\Model\Role\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    public function index() {
        $roles = Role::all();

        return view('admin.roles.index', compact('roles'));
    }

    public function save(Request $request, Role $role = null) {
        $data = $request->get('role');

        if(empty($data['name'])) {
            return redirect()->back();
        }

        $role->name = $data['name'];
        $role->display_name = $data['display_name'];
        $role->description = empty($data['description']) ? null : $data['description'];
        $role->save();

        $role->permissions()->detach();
        $permissions = $request->get('permission');
        if(count($permissions) > 0) {
            foreach($permissions as $permission_id) {
                $role->permissions()->attach($permission_id);
            }
        }

        return redirect()->back();
    }

    public function edit(Role $role) {

        $permissions = Permission::orderBy('display_name')->get();

        return view('admin.roles.edit', compact('role', 'permissions'));
    }

}
