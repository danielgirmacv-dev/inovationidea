<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Super Admin / Innovation Admin
        User::updateOrCreate(
            ['email' => 'admin@eec.com.et'],
            [
                'name' => 'EEC Innovation Admin',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'job_title' => 'Chief Innovation Officer',
                'department' => 'Corporate Strategy & Innovation',
                'site' => 'Head Office - Addis Ababa',
                'phone' => '+251 11 551 7700',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // 2. Innovation Reviewer 1 (Technical & Engineering)
        User::updateOrCreate(
            ['email' => 'reviewer@eec.com.et'],
            [
                'name' => 'Alemayehu Tadesse',
                'password' => Hash::make('password123'),
                'role' => 'reviewer',
                'job_title' => 'Senior Civil Engineer & Technical Reviewer',
                'department' => 'Infrastructure Engineering',
                'site' => 'Head Office - Addis Ababa',
                'phone' => '+251 91 123 4567',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // 3. Innovation Reviewer 2 (Digital & Systems)
        User::updateOrCreate(
            ['email' => 'bethlehem@eec.com.et'],
            [
                'name' => 'Bethlehem Kebede',
                'password' => Hash::make('password123'),
                'role' => 'reviewer',
                'job_title' => 'Lead Systems Architect',
                'department' => 'Digital Transformation & ICT',
                'site' => 'Bole Sub-Office',
                'phone' => '+251 92 345 6789',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // 4. Regular Employee / Submitter Account
        User::updateOrCreate(
            ['email' => 'dawit@eec.com.et'],
            [
                'name' => 'Dawit Mengistu',
                'password' => Hash::make('password123'),
                'role' => 'employee',
                'job_title' => 'Site Operations Supervisor',
                'department' => 'Water & Energy Design',
                'site' => 'Awash Project Site',
                'phone' => '+251 93 456 7890',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
