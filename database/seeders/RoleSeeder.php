<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::insert([
            [
                'title' => 'Sales Rep',
                'is_default' => "1"
            ],
            [
                'title' => 'Sales Manager',
                'is_default' => "1"
            ],
            [
                'title' => 'TeleMarketing Rep',
                'is_default' => "1"
            ],
            [
                'title' => 'Director',
                'is_default' => "1"
            ],
            [
                'title' => 'Onboarding Rep',
                'is_default' => "1"
            ],
            [
                'title' => 'Onboarding Manager',
                'is_default' => "1"
            ]
        ]);
    }
}
