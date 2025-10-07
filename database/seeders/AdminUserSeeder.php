<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or Update Admin User
        User::updateOrCreate(
            ['email' => 'admin@erp.com'],
            [
                'name' => 'System Administrator',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'employee_role' => null,
                'email_verified_at' => now(),
            ]
        );

        // Create or Update HR Manager User
        User::updateOrCreate(
            ['email' => 'hr@erp.com'],
            [
                'name' => 'HR Manager',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'employee_role' => 'hr_manager',
                'email_verified_at' => now(),
            ]
        );

        // Create or Update Regular Employee User
        User::updateOrCreate(
            ['email' => 'employee@erp.com'],
            [
                'name' => 'John Employee',
                'password' => Hash::make('employee123'),
                'role' => 'user',
                'employee_role' => 'employee',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Admin users created/updated successfully!');
        $this->command->info('Admin Login: admin@erp.com / password123');
        $this->command->info('HR Manager Login: hr@erp.com / password123');
        $this->command->info('Employee Login: employee@erp.com / employee123');
    }
}