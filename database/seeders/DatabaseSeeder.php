<?php

namespace Database\Seeders;

use App\Models\User;
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
        User::create([
            'nombre' => 'Lucas',
            'email' => 'lu@hoff.com',
            'telefono' => '0983',
            'cedula' => '123',
            'rol' => '1',
            'user' => '123',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',

        ]);

        User::create([
            'nombre' => 'Genott',
            'email' => 'Genot@genott.com',
            'telefono' => '123123',
            'cedula' => '333',
            'rol' => '2',
            'user' => '123',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',

        ]);
        // \App\Models\User::factory(10)->create();
    }
}
