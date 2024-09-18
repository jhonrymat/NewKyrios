<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    use HasFactory;

    protected $table = 'ordenes';
    protected $primaryKey = 'codigo';
    protected $fillable = [
        'fecha', 'tecnico', 'nomcliente', 'celcliente', 'equipo', 'marca', 'modelo', 'serial',
        'cargador', 'bateria', 'otros', 'notacliente', 'observaciones', 'notatecnico',
        'valor', 'estado', 'fechafin', 'horainicio', 'reparado'
    ];
}
