<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class PurchasePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get admin role (assuming role with id 1 is admin)
        $adminRole = Sentinel::findRoleById(1);

        if (!$adminRole) {
            $this->command->error('Admin role not found! Please run RoleSeeder first.');
            return;
        }

        // Define purchase permissions
        $purchasePermissions = [
            'purchase.show' => true,
            'purchase.create' => true,
            'purchase.edit' => true,
            'purchase.destroy' => true,
        ];

        // Get existing permissions
        $existingPermissions = $adminRole->permissions;

        // Merge with new purchase permissions
        $updatedPermissions = array_merge($existingPermissions ?: [], $purchasePermissions);

        // Update admin role permissions
        $adminRole->permissions = $updatedPermissions;
        $adminRole->save();

        $this->command->info('Purchase permissions added successfully to Admin role!');
        $this->command->info('Permissions added:');
        foreach ($purchasePermissions as $permission => $value) {
            $this->command->info('  - ' . $permission);
        }
    }
}
