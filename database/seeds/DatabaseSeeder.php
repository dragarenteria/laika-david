<?php

use App\Departamento;
use App\Municipio;
use App\Pais;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

       $colombia = Pais::create([
            'nombre' => 'Colombia'
        ]);

        $choco = Departamento::create([
            'nombre' => 'Chocó',
            'pais_id' => $colombia->id
        ]);

       $cundinamarca = Departamento::create([
            'nombre' => 'Cundinamarca',
            'pais_id' => $colombia->id
        ]);

        $quibdo = Municipio::create([
            'nombre' => 'Quibdó',
            'departamento_id' => $choco->id
        ]);
        Municipio::create([
            'nombre' => 'Istmina',
            'departamento_id' => $choco->id
        ]);
        Municipio::create([
            'nombre' => 'Condoto',
            'departamento_id' => $choco->id
        ]);

        Municipio::create([
            'nombre' => 'Bogotá',
            'departamento_id' => $cundinamarca->id
        ]);

        Municipio::create([
            'nombre' => 'Tena',
            'departamento_id' => $cundinamarca->id
        ]);

        User::create([
            'name' => 'David',
            'apellidos' => 'Raga Renteria',
            'telefono' => '3206121376',
            'email' => 'davidragarenteria@gmail.com',
            'email_verified_at' => now(),
            'municipio_id' => $quibdo->id,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        factory(App\User::class, 5)->create();
    }
}
