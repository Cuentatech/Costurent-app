<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('alquileres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
            $table->foreignId('disfraz_id')->constrained('disfraces')->onDelete('cascade');
            $table->integer('cantidad')->default(1);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->enum('estado', ['reservada', 'activa', 'retrasada', 'finalizada', 'cancelada'])->default('reservada');
            $table->decimal('total', 10, 2);
            $table->integer('dias_retraso')->nullable();
            $table->decimal('monto_sancion', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('alquileres');
    }

};
