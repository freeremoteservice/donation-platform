<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate dependent tables first
        \App\Models\Campaign::truncate();
        \App\Models\Donation::truncate();
        \App\Models\User::truncate();

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        User::insert([
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'email_verified_at' => now(),
                'password' => '$2y$12$wFkR5r15vyv.JdrHyES8ueIN0OL0U2.KqKp3mGrFwu2m3YWF1ZXMG', // already hashed
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Test',
                'email' => 'test@gmail.com',
                'email_verified_at' => now(),
                'password' => '$2y$12$wFkR5r15vyv.JdrHyES8ueIN0OL0U2.KqKp3mGrFwu2m3YWF1ZXMG',
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Test2',
                'email' => 'test2@gmail.com',
                'email_verified_at' => now(),
                'password' => '$2y$12$wFkR5r15vyv.JdrHyES8ueIN0OL0U2.KqKp3mGrFwu2m3YWF1ZXMG',
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
