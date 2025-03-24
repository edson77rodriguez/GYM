<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MarcasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $marcas = [
            ['nom_marca' => 'Optimum Nutrition'],
            ['nom_marca' => 'BSN'],
            ['nom_marca' => 'MuscleTech'],
            ['nom_marca' => 'Dymatize'],
            ['nom_marca' => 'Cellucor'],
            ['nom_marca' => 'Jym Supplement Science'],
            ['nom_marca' => 'MusclePharm'],
            ['nom_marca' => 'Gaspari Nutrition'],
            ['nom_marca' => 'Universal Nutrition'],
            ['nom_marca' => 'AllMax Nutrition'],
        ];

        DB::table('marcas')->insert($marcas);
    }
}
