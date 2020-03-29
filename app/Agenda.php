<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $fillable = [
        'x_id',
        'x_data',
        'x_colaborador_id',
        'x_unidade',
        'x_periodos',
        'x_cidade',
        'x_procedimento',
        'x_obs'
    ];

    protected $dates = ['deleted_at'];

    protected $table = 'agenda';
}
