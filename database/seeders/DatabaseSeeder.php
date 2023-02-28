<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use DB;
use Hash;

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

        DB::table('users')->insert(
            [
                [
                    'avatar' => 'https://www.gravatar.com/avatar/' . md5(strtolower(trim('boughattas.naim@gmail.com'))) . '?d=identicon',
                    'name' => 'Naïm Boughattas',
                    'email' => 'boughattas.naim@gmail.com',
                    'email_verified_at' => now(),
                    'password' => Hash::make('123456'), // password
                ]
            ]
        );

        $admin = \App\Models\User::where('email', 'boughattas.naim@gmail.com')->first();
        $admin->roles()->sync(['1']);

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
