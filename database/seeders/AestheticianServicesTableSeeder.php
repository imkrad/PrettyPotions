<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AestheticianServicesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('aesthetician_services')->delete();
        
        \DB::table('aesthetician_services')->insert(array (
            0 => 
            array (
                'id' => 1,
                'category_id' => 1,
                'aesthetician_id' => 1,
                'created_at' => '2024-02-08 09:39:42',
                'updated_at' => '2024-02-08 09:39:42',
            ),
            1 => 
            array (
                'id' => 2,
                'category_id' => 9,
                'aesthetician_id' => 2,
                'created_at' => '2024-02-08 09:39:53',
                'updated_at' => '2024-02-08 09:39:53',
            ),
        ));
        
        
    }
}