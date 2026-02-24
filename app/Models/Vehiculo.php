<?php

namespace App\Models;

use App\Models\ParkingSession;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    /** @use HasFactory<\Database\Factories\VehiculoFactory> */
    use HasFactory;

    protected $fillable = [
        'placa',
        'tipo'
    ];

    public function parkingSession()
    {
        return $this->hasMany(ParkingSession::class);
    }
}
