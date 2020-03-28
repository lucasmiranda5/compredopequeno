<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContatoEmpresa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contato_empresa', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('tipo',['site','telefone','whatsapp']);
            $table->string('escrita');
            $table->string('direcionamento')->nullable();
            $table->integer('empresa');
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
        Schema::dropIfExists('contato_empresa');
    }
}
