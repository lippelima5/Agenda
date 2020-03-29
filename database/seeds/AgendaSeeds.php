// AgendaSeed.php
<?php

use Illuminate\Database\Seeder;

class JobsSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Agenda::create([
            'x_data' => '2020-02-10',
            'x_colaborador_id' => 1,
            'x_unidade' => str_random(10),
            'x_periodos' => str_random(1),
            'x_cidade' => str_random(10),
            'x_procedimento' => str_random(10),
            'x_obs' => str_random(50),
        ]);
    }
}
