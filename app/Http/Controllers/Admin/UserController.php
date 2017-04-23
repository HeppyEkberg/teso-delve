<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Role\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{

    public function index() {
        $users = User::with(['characters', 'roles'])->get();
        return view('admin.users.index', compact('users'));
    }

    public function ghost(User $user) {
        Auth::login($user);
        return redirect(route('home.index'));
    }

    public function downloadLua(User $user) {
        $storage = storage_path('dumps/');
        $file = $storage."dump_$user->id.lua";

        if(!File::exists($file)) {
            abort(403);
        }

        return response()->download($file);
    }

    public function edit(User $user) {
        $roles = Role::all();
        $userRoles = $user->roles->keyBy('id');
        return view('admin.users.edit', compact('user', 'roles', 'userRoles'));
    }

    public function update(Request $request, User $user) {
        $addRole = $request->get('role');

        $user->roles()->detach();
        foreach($addRole as $role_id => $role) {
            $user->roles()->attach($role_id);
        }

        return redirect()->back();
    }

}
