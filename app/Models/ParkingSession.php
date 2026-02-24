<?php

namespace App\Models;

use App\Models\Sede;
use App\Models\Vehiculo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingSession extends Model
{
    /** @use HasFactory<\Database\Factories\ParkingSessionFactory> */
    use HasFactory;

    protected $fillable = [
        'sede_id',
        'vehiculo_id',
        'hora_entrada',
        'hora_salida',
        'valor',
        'estado',
    ];

    protected $casts = [
        'hora_entrada' => 'datetime',
        'hora_salida' => 'datetime',
    ];

    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class);
    }
}
