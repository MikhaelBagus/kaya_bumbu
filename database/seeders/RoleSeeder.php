<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sentinel::getRoleRepository()->createModel()->create([
            'name'        => 'Root',
            'permissions' => ['dashboard' => true],
            'slug'        => 'root',
            'created_by'  => 'Root',
            'updated_by'  => 'Root',
        ]);

        Sentinel::getRoleRepository()->createModel()->create([
            'name'        => 'Member',
            'permissions' => [],
            'slug'        => 'member',
            'created_by'  => 'Root',
            'updated_by'  => 'Root',
        ]);
    }
}