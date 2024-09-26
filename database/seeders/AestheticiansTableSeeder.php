<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AestheticiansTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('aestheticians')->delete();
        
        \DB::table('aestheticians')->insert(array (
            0 => 
            array (
                'id' => 1,
                'specialist_id' => 15,
                'user_id' => 7,
                'is_active' => 1,
                'created_at' => '2024-02-08 09:39:42',
                'updated_at' => '2024-02-08 09:39:42',
            ),
            1 => 
            array (
                'id' => 2,
                'specialist_id' => 16,
                'user_id' => 8,
                'is_active' => 1,
                'created_at' => '2024-02-08 09:39:53',
                'updated_at' => '2024-02-08 09:39:53',
            ),
        ));
        
        
    }
}