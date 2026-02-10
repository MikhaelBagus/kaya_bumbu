<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CostCenter;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class CostCenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = Sentinel::getUser();
        $email = $user ? $user->email : 'system@admin.com';

        $costCenters = [
            [
                'code' => 'CC-OPS',
                'name' => 'Operations',
                'description' => 'Operational Cost Center',
                'is_active' => true,
                'created_by' => $email,
            ],
            [
                'code' => 'CC-MKT',
                'name' => 'Marketing',
                'description' => 'Marketing Cost Center',
                'is_active' => true,
                'created_by' => $email,
            ],
            [
                'code' => 'CC-PROD',
                'name' => 'Production',
                'description' => 'Production Cost Center',
                'is_active' => true,
                'created_by' => $email,
            ],
            [
                'code' => 'CC-ADM',
                'name' => 'Administration',
                'description' => 'Administration Cost Center',
                'is_active' => true,
                'created_by' => $email,
            ],
            [
                'code' => 'CC-HR',
                'name' => 'Human Resources',
                'description' => 'HR Cost Center',
                'is_active' => true,
                'created_by' => $email,
            ],
            [
                'code' => 'CC-IT',
                'name' => 'Information Technology',
                'description' => 'IT Cost Center',
                'is_active' => true,
                'created_by' => $email,
            ],
        ];

        foreach ($costCenters as $costCenter) {
            CostCenter::create($costCenter);
        }

        $this->command->info('Cost Centers seeded successfully!');
    }
}
