<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserProfilesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('user_profiles')->delete();
        
        \DB::table('user_profiles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'firstname' => 'Al Francis',
                'lastname' => 'Abat',
                'middlename' => 'A',
                'suffix' => NULL,
                'gender' => 'Male',
                'mobile' => '09123456780',
                'user_id' => 1,
                'created_at' => '2024-02-08 04:04:05',
                'updated_at' => '2024-02-08 04:04:05',
            ),
            1 => 
            array (
                'id' => 2,
                'firstname' => 'John',
                'lastname' => 'Doe',
                'middlename' => 'M',
                'suffix' => NULL,
                'gender' => 'Male',
                'mobile' => '09123654789',
                'user_id' => 2,
                'created_at' => '2024-02-08 04:04:31',
                'updated_at' => '2024-02-08 04:04:31',
            ),
            2 => 
            array (
                'id' => 3,
                'firstname' => 'Shaheen',
                'lastname' => 'Alamera',
                'middlename' => 'K',
                'suffix' => NULL,
                'gender' => 'Female',
                'mobile' => '0321654789',
                'user_id' => 3,
                'created_at' => '2024-02-08 04:05:15',
                'updated_at' => '2024-02-08 04:13:13',
            ),
            3 => 
            array (
                'id' => 4,
                'firstname' => 'Marian',
                'lastname' => 'Rivera',
                'middlename' => '',
                'suffix' => NULL,
                'gender' => 'Female',
                'mobile' => '0321456123',
                'user_id' => 4,
                'created_at' => '2024-02-08 04:08:20',
                'updated_at' => '2024-02-08 04:08:20',
            ),
            4 => 
            array (
                'id' => 5,
                'firstname' => 'Albert',
                'lastname' => 'Padilla',
                'middlename' => 'I',
                'suffix' => NULL,
                'gender' => 'M',
                'mobile' => '09123654879',
                'user_id' => 5,
                'created_at' => '2024-02-08 04:19:47',
                'updated_at' => '2024-02-08 04:19:47',
            ),
            5 => 
            array (
                'id' => 6,
                'firstname' => 'Pretty',
                'lastname' => 'Ibrahim',
                'middlename' => '',
                'suffix' => NULL,
                'gender' => 'F',
                'mobile' => '03216543213',
                'user_id' => 6,
                'created_at' => '2024-02-08 04:24:43',
                'updated_at' => '2024-02-08 04:24:43',
            ),
            6 => 
            array (
                'id' => 7,
                'firstname' => 'Albert',
                'lastname' => 'Einstein',
                'middlename' => '',
                'suffix' => NULL,
                'gender' => 'Male',
                'mobile' => '06321456987',
                'user_id' => 7,
                'created_at' => '2024-02-08 08:46:13',
                'updated_at' => '2024-02-08 08:46:13',
            ),
            7 => 
            array (
                'id' => 8,
                'firstname' => 'Shein',
                'lastname' => 'Bernardo',
                'middlename' => '',
                'suffix' => NULL,
                'gender' => 'Female',
                'mobile' => '0321456687',
                'user_id' => 8,
                'created_at' => '2024-02-08 09:39:18',
                'updated_at' => '2024-02-08 09:39:18',
            ),
        ));
        
        
    }
}