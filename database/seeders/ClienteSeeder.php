<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Opción 1: Insertar varios clientes con datos reales (recomendada)
        DB::table('clientes')->insert([
            [
                'nombre'     => 'Juan',
                'apellidos'  => 'Pérez García',
                'email'      => 'juan.perez@gmail.com',
                'telefono'   => '612345678',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre'     => 'María',
                'apellidos'  => 'López Fernández',
                'email'      => 'maria.lopez@hotmail.com',
                'telefono'   => '623456789',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre'     => 'Carlos',
                'apellidos'  => 'Rodríguez Sánchez',
                'email'      => 'carlos.rodriguez@yahoo.com',
                'telefono'   => '634567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre'     => 'Ana',
                'apellidos'  => 'Martínez Ruiz',
                'email'      => 'ana.martinez@gmail.com',
                'telefono'   => '645678901',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre'     => 'Luis',
                'apellidos'  => 'Gómez Morales',
                'email'      => 'luis.gomez@outlook.com',
                'telefono'   => '656789012',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Opción 2: Usar Factory (más profesional y escalable) - Te la muestro abajo
    }
}