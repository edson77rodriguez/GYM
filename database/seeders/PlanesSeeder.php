<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $planes = [
            [
                'nom_plan' => 'Plan Mensual',
                'desc_plan' => 'Acceso al gimnasio durante un mes.',
                'costo' => 450.00,
            ],
            [
                'nom_plan' => 'Plan Bimestral',
                'desc_plan' => 'Acceso al gimnasio durante dos meses con un descuento.',
                'costo' => 850.00,
            ],
            [
                'nom_plan' => 'Plan Trimestral',
                'desc_plan' => 'Acceso al gimnasio durante tres meses con un descuento aún mayor.',
                'costo' => 1200.00,
            ],
            [
                'nom_plan' => 'Plan Semestral',
                'desc_plan' => 'Acceso al gimnasio durante seis meses con un descuento considerable.',
                'costo' => 2200.00,
            ],
            [
                'nom_plan' => 'Plan Anual',
                'desc_plan' => 'Acceso al gimnasio durante un año con el mejor descuento.',
                'costo' => 4000.00,
            ],
        ];

        DB::table('planes')->insert($planes);
    }
}
