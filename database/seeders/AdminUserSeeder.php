<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Obtener el id del rol Administrador
        $adminRoleId = DB::table('roles')->where('desc_rol', 'Administrador')->value('id_rol');
        
        // Insertar el usuario con rol de Administrador
        DB::table('personas')->insert([
            'nom' => 'Administrador',
            'ap' => 'Admin',
            'am' => 'Admin',
            'telefono' => '1234567890',
            'correo' => 'admin@admin.com',
            'contrasena' => Hash::make('password'), // Contraseña de ejemplo
            'id_rol' => $adminRoleId, // Usar el id del rol 'Administrador'
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Obtener el id_persona insertado
        $idPersona = DB::getPdo()->lastInsertId();

        // Insertar el usuario en la tabla 'users'
        DB::table('users')->insert([
            'name' => 'Administrador',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'id_persona' => $idPersona,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
