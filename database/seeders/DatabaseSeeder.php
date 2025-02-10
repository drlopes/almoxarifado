<?php

namespace Database\Seeders;

use Database\Seeders\TenantSeeder;
use Illuminate\Database\Seeder;
use App\Models\Tenant;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run() : void
    {
        $this->call([
            ShieldSeeder::class,
            TenantSeeder::class,
        ]);

        if (! app()->environment('production')) {

            $tenants = Tenant::all();

            $developer = User::factory()->create([
                'name' => 'Developer',
                'email' => 'developer@id-logistics.com',
                'password' => 'developer',
            ]);
            $developer->tenants()->attach($tenants);
            $developer->assignRole('developer');

            $admin = User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);

            $admin->tenants()->attach($tenants->shuffle()->take(5));
            $admin->assignRole('admin');
        }
    }
}
