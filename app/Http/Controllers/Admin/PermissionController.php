<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Role\Permission;
use App\Model\Role\Role;
use Illuminate\Http\Request;

class PermissionController extends Controller
{

    public function store(Request $request, Permission $permission) {
        $data = $request->get('permission');

        $permission->name = $data['name'];
        $permission->display_name = $data['display_name'];
        $permission->description = empty($data['description']) ? null : $data['description'];
        $permission->save();

        return redirect()->back();
    }

}
