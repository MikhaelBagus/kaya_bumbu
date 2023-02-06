<?php

namespace App\Traits\Users;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

trait AttachRoleTrait
{
    /**
     * Attach User To Role
     *
     * @param $userDb
     * @param $roleName
     */
    private function attach($userDb, $roleName)
    {
        $role = Sentinel::findRoleByName($roleName);
        $role->users()->attach($userDb);
    }
}
