<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agenda', function (Blueprint $table) {
            $table->increments('x_id');
            $table->date('x_data')->nullable(false);
            $table->integer('x_colaborador_id')->unsigned();
            $table->foreign('x_colaborador_id')
                ->references('c_id')
                ->on('colaboradores')
                ->onDelete('cascade');
            $table->string('x_unidade')->nullable(false);
            $table->string('x_periodos', 1)->nullable(false);
            $table->string('x_cidade')->nullable(false);
            $table->string('x_procedimento')->nullable(false);
            $table->longText('x_obs');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agenda');
    }
}
