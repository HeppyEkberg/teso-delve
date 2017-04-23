<?php

namespace App\Model\Role;

use Laratrust\LaratrustRole;

class Role extends LaratrustRole
{

    public function getRouteKeyName()
    {
        return 'name';
    }

}
