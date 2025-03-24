<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categorias = [
            ['nom_cat' => 'Aminoácidos'],
            ['nom_cat' => 'Pre-entrenos'],
            ['nom_cat' => 'Vitaminas'],
            ['nom_cat' => 'Gainers'],
            ['nom_cat' => 'Termogénicos'],
            ['nom_cat' => 'Glutamina'],
            ['nom_cat' => 'Hydrolyzed Protein'],
        ];

        DB::table('categorias')->insert($categorias);
    }
}
