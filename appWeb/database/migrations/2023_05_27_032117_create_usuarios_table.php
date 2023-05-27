<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// TODO, Migración de usuario
return new class extends Migration
{

    // * Tabla de referencia
    public  $tabla = "usuarios";

    // * Migración
    public function up(): void
    {
        // * Columnas
        Schema::create($this->tabla, function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('email')->unique();
            $table->string('apellido_paterno');
            $table->string('apellido_materno');
            $table->string('telefono')->nullable();
            $table->boolean('isActivo')->default(true);
            $table->timestamps();
        });
    }

    //  * Invertir la migración
    public function down(): void
    {
        Schema::dropIfExists($this->tabla);
    }
};
