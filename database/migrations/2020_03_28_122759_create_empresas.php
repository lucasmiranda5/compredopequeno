<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpresas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome');
            $table->integer('categoria')->nullable();
            $table->text('descricao')->nullable();
            $table->string('marca')->nullable();
            $table->text('horario_funcionamento')->nullable();
            $table->string('nome_responsavel')->nullable();
            $table->string('telefone_responsavel')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empresas');
    }
}
