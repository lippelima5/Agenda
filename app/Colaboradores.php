<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Colaboradores extends Model
{
    protected $fillable = ['c_id', 'c_nome_completo', 'c_usuario', 'c_email', 'c_senha', 'c_tipo', 'c_key'];

  //  protected $hidden = ['c_senha'];

    protected $table = 'colaboradores';
   
}
