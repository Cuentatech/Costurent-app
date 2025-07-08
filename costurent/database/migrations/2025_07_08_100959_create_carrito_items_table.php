<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarritoItemsTable extends Migration
{
    public function up()
    {
        Schema::create('carrito_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('disfraz_id');
            $table->integer('cantidad')->default(1);
            $table->timestamps();

            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');
            $table->foreign('disfraz_id')->references('id')->on('disfraces')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('carrito_items');
    }
}

