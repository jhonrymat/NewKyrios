<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordenes', function (Blueprint $table) {
            $table->id('codigo'); // Equivalente a 'AUTO_INCREMENT'
            $table->string('fecha', 10); // VARCHAR(10)
            $table->string('tecnico', 60); // VARCHAR(60)
            $table->string('nomcliente', 60); // VARCHAR(60)
            $table->string('celcliente', 20)->nullable(); // VARCHAR(20) con valor NULL permitido
            $table->string('equipo', 60); // VARCHAR(60)
            $table->string('marca', 30); // VARCHAR(30)
            $table->string('modelo', 30); // VARCHAR(30)
            $table->string('serial', 30); // VARCHAR(30)
            $table->text('cargador')->nullable(); // TEXT, con valor NULL permitido
            $table->text('bateria')->nullable(); // TEXT, con valor NULL permitido
            $table->text('otros')->nullable(); // TEXT, con valor NULL permitido
            $table->string('notacliente', 255); // VARCHAR(255)
            $table->string('observaciones', 255)->nullable(); // VARCHAR(255) con valor NULL permitido
            $table->string('notatecnico', 255)->nullable(); // VARCHAR(255) con valor NULL permitido
            $table->string('valor', 20)->nullable(); // VARCHAR(20)
            $table->string('estado', 10)->index();
            ; // VARCHAR(10)
            $table->string('fechafin', 10)->nullable(); // VARCHAR(10), con valor NULL permitido
            $table->string('horainicio', 12); // VARCHAR(12)
            $table->string('reparado', 12); // VARCHAR(12)

            $table->timestamps(); // Esto añadirá las columnas 'created_at' y 'updated_at'

            // Añadir el índice para 'codigo'
            $table->index('codigo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ordenes');
    }
};
