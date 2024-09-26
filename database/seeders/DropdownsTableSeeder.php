<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DropdownsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('dropdowns')->delete();
        
        \DB::table('dropdowns')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Facial Treatment',
                'classification' => 'Category',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Mesotherapy',
                'classification' => 'Category',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Beauty Push Drip and Boosters',
                'classification' => 'Category',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Slimming Therapy',
                'classification' => 'Category',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Hair Removal',
                'classification' => 'Category',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Lashes',
                'classification' => 'Category',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Semi-Permanent Make-up',
                'classification' => 'Category',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Body Treatments',
                'classification' => 'Category',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Nails',
                'classification' => 'Category',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'SPA',
                'classification' => 'Category',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Threadlifts',
                'classification' => 'Category',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Botox',
                'classification' => 'Category',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'Mesotheraphy Injection',
                'classification' => 'Category',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'Dermal Fillers',
                'classification' => 'Category',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'Facialist',
                'classification' => 'Specialist',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'Nail Technician',
                'classification' => 'Specialist',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'Nurse',
                'classification' => 'Specialist',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'Doctor',
                'classification' => 'Specialist',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'Pending',
                'classification' => 'Status',
                'type' => 'n/a',
                'color' => 'bg-warning',
                'others' => 'text-warning',
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'Completed',
                'classification' => 'Status',
                'type' => 'n/a',
                'color' => 'bg-success',
                'others' => 'text-success',
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'Cancelled',
                'classification' => 'Status',
                'type' => 'n/a',
                'color' => 'bg-danger',
                'others' => 'text-danger',
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'Confirmed',
                'classification' => 'Status',
                'type' => 'n/a',
                'color' => 'bg-info',
                'others' => 'text-info',
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'Ongoing',
                'classification' => 'Status',
                'type' => 'n/a',
                'color' => 'bg-primary',
                'others' => 'text-primary',
            ),
        ));
        
        
    }
}