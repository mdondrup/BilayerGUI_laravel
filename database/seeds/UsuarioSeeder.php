<?php

use App\Usuario;
use Illuminate\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Usuario::create([
            'name' => 'felipe.costoya',
            'email' => 'felipe.demo@supepmem.com',
            'password' => bcrypt('demo')
        ]);

        Usuario::create([
            'name' => 'rebeca.garcia',
            'email' => 'rebeca.demo@supepmem.com',
            'password' => bcrypt('demo')
        ]);

        Usuario::create([
            'name' => 'angel.piñeiro',
            'email' => 'angel.demo@supepmem.com',
            'password' => bcrypt('demo')
        ]);
    }
}
