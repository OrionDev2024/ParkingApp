<?php

namespace App\Models;

use App\Models\ParkingSession;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
    /** @use HasFactory<\Database\Factories\SedeFactory> */
    use HasFactory;

    protected $fillable = [
        'nombre',
        'cupo_motos',
        'cupo_carros',
        'total_motos',
        'total_carros',
        'tarifa_hora_motos',
        'tarifa_hora_carros',
        'tarifa_minutos_motos',
        'tarifa_minutos_carros',
    ];


    public function parkingSession()
    {
        return $this->hasMany(ParkingSession::class);
    }
}
