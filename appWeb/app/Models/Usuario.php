<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// TODO, Modelo del usuario
class Usuario extends Model
{

    // * Vincular el modelo con un factory
    use HasFactory;

    // * Tabla de referencia
    protected $table = 'usuarios';

    //* Columnas a mostrar
    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'teléfono',
        "email",
        "isActivo"
    ];

    // * Ocultas
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
