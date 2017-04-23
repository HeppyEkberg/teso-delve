<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $roles = file_get_contents(storage_path('dump/roles.json'));
        $permissions = file_get_contents(storage_path('dump/permissions.json'));
        $permissionRoles = file_get_contents(storage_path('dump/permissionRole.json'));

        $roles = json_decode($roles);
        $permissions = json_decode($permissions);
        $permissionRoles = json_decode($permissionRoles);

        foreach($roles as $role) {
            DB::table('roles')->insert((array) $role);
        }

        foreach($permissions as $permission) {
            DB::table('permissions')->insert((array) $permission);
        }

        foreach($permissionRoles as $permissionRole) {
            unset($permissionRole->id);
            DB::table('permission_role')->insert((array) $permissionRole);
        }

        $user = \App\User::find(1);

        $user->roles()->attach(1);
        $user->roles()->attach(3);

    }
}
