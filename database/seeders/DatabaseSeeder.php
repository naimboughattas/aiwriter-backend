<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        DB::table('roles')->insert(
            [
                [
                    'id' => 1,
                    'name' => 'Admin',
                ],
                [
                    'id' => 2,
                    'name' => 'User',
                ],
                [
                    'id' => 3,
                    'name' => 'Guest',
                ]
            ]
        );

        $roles = \App\Models\Role::all();

        $user = \App\Models\User::factory()
            ->count(3)
            ->hasAttached($roles)
            ->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
