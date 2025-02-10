<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenants = [
            [
                'code' => 'dev',
                'client' => 'Developent',
                'description' => 'Development Tenant',
            ]
        ];

        Tenant::insert($tenants);
    }
}
