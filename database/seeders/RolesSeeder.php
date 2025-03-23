<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Hash;
class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Insertar los roles
        DB::table('roles')->insert([
            ['desc_rol' => 'Administrador'],
            ['desc_rol' => 'Socio'],
            ['desc_rol' => 'Empleado'],
            ['desc_rol' => 'Proveedor'],
        ]);
    }

}
