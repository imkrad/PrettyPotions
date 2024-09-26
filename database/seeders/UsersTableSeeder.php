<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'username' => 'administrator',
                'email' => 'admin@prettypotions.com',
                'email_verified_at' => '2024-02-08 04:04:05',
                'password' => '$2y$12$OXnbTELtLXCWqnZnb38h6u.U0KKkCyw9kG.YdZMe41ZLguU/tK5AW',
                'avatar' => 'administrator.png',
                'role' => 'Administrator',
                'is_active' => 1,
                'welcome_valid_until' => NULL,
                'remember_token' => NULL,
                'created_at' => '2024-02-08 04:04:05',
                'updated_at' => '2024-02-08 04:04:05',
            ),
            1 => 
            array (
                'id' => 2,
                'username' => 'johndoe',
                'email' => 'johndoe@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$12$U4Vf7R1RWTHnMGW.ff/ROei6MRcaLz57XFgCYWBkWWd3WfF/csdsC',
                'avatar' => 'johndoe.jpeg',
                'role' => 'Receptionist',
                'is_active' => 1,
                'welcome_valid_until' => NULL,
                'remember_token' => NULL,
                'created_at' => '2024-02-08 04:04:31',
                'updated_at' => '2024-02-08 04:04:31',
            ),
            2 => 
            array (
                'id' => 3,
                'username' => 'alamera',
                'email' => 'alamera@yahoo.com',
                'email_verified_at' => NULL,
                'password' => '$2y$12$IjseAsI.wdvFro5LuekfnO4ztn/2wSM0yBJ1qsCi9SU1d065SwLt6',
                'avatar' => 'alamera.jpeg',
                'role' => 'Receptionist',
                'is_active' => 1,
                'welcome_valid_until' => NULL,
                'remember_token' => NULL,
                'created_at' => '2024-02-08 04:05:15',
                'updated_at' => '2024-02-08 04:05:15',
            ),
            3 => 
            array (
                'id' => 4,
                'username' => 'marian',
                'email' => 'marian@yahoo.com',
                'email_verified_at' => NULL,
                'password' => '$2y$12$dWIZq4GUCFEyq/a6nxoKXuhUxjWVFCjoxn7oKIl7LFV/ve6OP.Qdy',
                'avatar' => 'marian.jpeg',
                'role' => 'Owner',
                'is_active' => 1,
                'welcome_valid_until' => NULL,
                'remember_token' => NULL,
                'created_at' => '2024-02-08 04:08:20',
                'updated_at' => '2024-02-08 04:08:20',
            ),
            4 => 
            array (
                'id' => 5,
                'username' => 'strong',
                'email' => 'strong@yahoo.com',
                'email_verified_at' => NULL,
                'password' => '$2y$12$UVjRrdBjblDPfyeTdvOQhuM5ih3VmKw6AosiSOMgjrAstviKJDhua',
                'avatar' => 'strong.jpeg',
                'role' => 'Client',
                'is_active' => 1,
                'welcome_valid_until' => NULL,
                'remember_token' => NULL,
                'created_at' => '2024-02-08 04:19:47',
                'updated_at' => '2024-02-08 04:19:47',
            ),
            5 => 
            array (
                'id' => 6,
                'username' => 'pretty',
                'email' => 'pretty@yahoo.com',
                'email_verified_at' => NULL,
                'password' => '$2y$12$UEFg27WobeDgdm0I0eF9hep1daYi8X22l9FAhbWEHTRJcY3Ee2XrG',
                'avatar' => 'pretty.jpeg',
                'role' => 'Client',
                'is_active' => 1,
                'welcome_valid_until' => NULL,
                'remember_token' => NULL,
                'created_at' => '2024-02-08 04:24:43',
                'updated_at' => '2024-02-08 04:24:43',
            ),
            6 => 
            array (
                'id' => 7,
                'username' => 'albert',
                'email' => 'albert@yahoo.com',
                'email_verified_at' => NULL,
                'password' => '$2y$12$fsxJKuNPu94RcrIO2bSNWug1Yos4OOmnBp4E4LzN3LrVA.30KVXK2',
                'avatar' => 'albert.jpeg',
                'role' => 'Staff',
                'is_active' => 1,
                'welcome_valid_until' => NULL,
                'remember_token' => NULL,
                'created_at' => '2024-02-08 08:46:13',
                'updated_at' => '2024-02-08 08:46:13',
            ),
            7 => 
            array (
                'id' => 8,
                'username' => 'shein',
                'email' => 'shein@yahoo.com',
                'email_verified_at' => NULL,
                'password' => '$2y$12$QJDZU/quPBdVtlM6pa5PlOZcW6XrweuvQ9Ez2MhALz8l6IOCVdbea',
                'avatar' => 'shein.jpeg',
                'role' => 'Staff',
                'is_active' => 1,
                'welcome_valid_until' => NULL,
                'remember_token' => NULL,
                'created_at' => '2024-02-08 09:39:18',
                'updated_at' => '2024-02-08 09:39:18',
            ),
        ));
        
        
    }
}