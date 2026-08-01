<?php

namespace Database\Seeders;

use App\Models\BusinessRule;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Admin User
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@moneybeing.com'],
            ['name' => 'Admin User', 'password' => \Illuminate\Support\Facades\Hash::make('password')]
        );

        // Seed Business Rules
        BusinessRule::insert([
            ['rule_field' => 'Age', 'operator' => '>=', 'value' => '21'],
            ['rule_field' => 'Age', 'operator' => '<=', 'value' => '60'],
            ['rule_field' => 'Monthly Income', 'operator' => '>=', 'value' => '30000'],
            ['rule_field' => 'Credit Score', 'operator' => '>=', 'value' => '700'],
            ['rule_field' => 'Loan Amount', 'operator' => '<=', 'value' => '80% Property Value'],
        ]);
    }
}
