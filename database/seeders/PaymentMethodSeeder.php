<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class PaymentMethodSeeder extends Seeder
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

        $paymentMethods = [
            [
                'name' => 'Full Payment',
                'description' => 'Full Payment',
                'is_active' => true,
                'created_by' => $email,
            ],
            [
                'name' => 'Instalment',
                'description' => 'Instalment Payment',
                'is_active' => true,
                'created_by' => $email,
            ],
        ];

        foreach ($paymentMethods as $method) {
            PaymentMethod::create($method);
        }

        $this->command->info('Payment Methods seeded successfully!');
    }
}
