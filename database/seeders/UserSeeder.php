<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // if (Role::where('role_name', 'customer')->first()) {
    //         $user->roles()->attach(Role::where('role_name', 'customer')->first()->id_role);
    //     }
    public function run(): void
    {

        // Seeding data admin
        foreach (['admin1', 'admin2', 'admin3'] as $username) {
            $user = User::firstOrCreate(['username'=>$username], [
                    'email'=>$username . '@mail.com',
                    'password'=>Hash::make('pw' . $username)
                ]);
                if (Role::where('role_name', 'admin')->first()) {
                    $user->roles()->attach(Role::where('role_name', 'admin')->first()->id_role);
                }
        }
    }
}
