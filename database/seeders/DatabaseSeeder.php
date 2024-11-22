<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \DB::table('users')->insert([
            'username' => 'administrator',
            'email' => 'admin@prettypotions.com',
            'password' => bcrypt('123456789'),
            'role' => 'Administrator',
            'avatar' => 'administrator.png',
            'is_active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
            'email_verified_at' => now(),
        ]);

        \DB::table('user_profiles')->insert([
            'firstname' => 'Al Francis',
            'lastname' => 'Abat',
            'middlename' => 'A',
            'gender' => 'Male',
            'user_id' => 1,
            'mobile' => '09123456789',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $this->call(DropdownsTableSeeder::class);
        $this->call(ServicesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(UserProfilesTableSeeder::class);
        $this->call(AestheticiansTableSeeder::class);
        $this->call(AestheticianServicesTableSeeder::class);
    }
}
