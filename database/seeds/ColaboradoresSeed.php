// Colaboradores.php
<?php

use Illuminate\Database\Seeder;

class CompaniesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */ 
    public function run()
    {
        App\Colaboradores::create([
            'c_nome_completo' => str_random(10),
            'c_usuario' => str_random(10),
            'c_email' => str_random(10).'@gmail.com',
            'c_senha' => bcrypt('secret'),
            'c_tipo' => random_int(1,3),
        ]);
    }
}