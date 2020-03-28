<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpresasCidades extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cidades_empresas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('empresa');
            $table->integer('cidade');
            $table->enum('entrega',['s','n']);
            $table->double('taxa_entrega')->nullable();
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
        Schema::dropIfExists('cidades_empresas');
    }
}
