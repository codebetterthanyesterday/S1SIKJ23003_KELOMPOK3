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
    public static function adminSeed()
    {
        // Version 1
        for ($i = 1; $i <= 5; $i++) {
            $user = User::firstOrCreate(['username' => 'admin' . $i], [
                'email' => 'admin' . $i . '@mail.com',
                'password' => Hash::make('pwadmin' . $i)
            ]);
            if (Role::where('role_name', 'admin')->first()) {
                $user->roles()->attach(Role::where('role_name', 'admin')->first()->id_role);
            }
        }
    }
    public static function customerSeed()
    {
        // Version 1
        for ($i = 1; $i <= 15; $i++) {
            $user = User::firstOrCreate(['username' => 'customer' . $i], [
                'email' => 'customer' . $i . '@mail.com',
                'password' => Hash::make('pwcustomer' . $i)
            ]);
            if (Role::where('role_name', 'customer')->first()) {
                $user->roles()->attach(Role::where('role_name', 'customer')->first()->id_role);
            }
        }
    }
    public static function sellerSeed()
    {
        // Version 1
        for ($i = 1; $i <= 10; $i++) {
            $user = User::firstOrCreate(['username' => 'seller' . $i], [
                'email' => 'seller' . $i . '@mail.com',
                'password' => Hash::make('pwseller' . $i)
            ]);
            if (Role::where('role_name', 'seller')->first()) {
                $user->roles()->attach(Role::where('role_name', 'seller')->first()->id_role);
            }
        }
    }
    public function run(): void
    {
        // Seeding data admin
        // self::adminSeed();

        // Seeding data customer
        // self::customerSeed();

        // Seeding data seller
        self::sellerSeed();
    }
}
