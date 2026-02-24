<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreParkingSessionRequest;
use App\Http\Requests\UpdateParkingSessionRequest;
use App\Models\ParkingSession;
use App\Models\Sede;
use App\Models\Vehiculo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParkingSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $parkingSessions = ParkingSession::all();
        return view('parkingSession.index', compact('parkingSessions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('parkingSession.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreParkingSessionRequest $request)
    {
        try {
            DB::beginTransaction();

            $placa = strtoupper($request->placa);

            $vehiculo = Vehiculo::firstOrCreate(
                ['placa' => $placa],
                ['tipo' => $request->tipo],
            );

            $sessionActiva = ParkingSession::where('vehiculo_id', $vehiculo->id)
                ->where('estado', true)
                ->exists();

            if ($sessionActiva) {
                DB::rollBack();

                return back()->withErrors([
                    'placa' => 'Este vehículo ya se encuentra dentro del parqueadero.'
                ])->withInput();
            }

            $sede = Sede::firstOrFail();
            if ($request->tipo === 'CARRO') {

                if ($sede->total_carros >= $sede->cupo_carros) {
                    DB::rollBack();

                    return back()->withErrors([
                        'placa' => 'No hay cupos disponibles para carros.'
                    ])->withInput();
                }

                // Incrementar total de carros
                $sede->increment('total_carros');
            }
            if($request->tipo === 'MOTO') { // MOTO

                if ($sede->total_motos >= $sede->cupo_motos) {
                    DB::rollBack();

                    return back()->withErrors([
                        'placa' => 'No hay cupos disponibles para motos.'
                    ])->withInput();
                }

                // Incrementar total de motos
                $sede->increment('total_motos');
            }
            ParkingSession::create([
                'sede_id' => $sede->id,
                'vehiculo_id' => $vehiculo->id,
                'hora_entrada' => now(),
                'hora_salida' => null,
                'valor' => null,
                'estado' => true,
            ]);

            DB::commit();

            return redirect()->route('sede.index')->with('succes', 'Entrada Registrada correctamente.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->withErrors([
                'error' => 'Ocurrió un error al registrar la entrada.'
            ])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ParkingSession $parkingSession)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ParkingSession $parkingSession)
    {
        //
    }
    public function editar()
    {
        return view('parkingSession.edit');
    }
    public function buscar(StoreParkingSessionRequest $request)
    {
        // buscar el vehiculo
        $placa = strtoupper($request->placa);
        $vehiculo = Vehiculo::where('placa', $placa)->first();
        if (!$vehiculo) {
            return back()->with('error', 'Vehículo no registrado.');
        }

        // buscar una sesión activa
        $parkingSession = ParkingSession::where('vehiculo_id', $vehiculo->id)
            ->whereNull('hora_salida')->first();

        if (!$parkingSession) {
            return back()->with('error', 'No se encontro un vehículo activo en al parqueadero.');
        }
        // obtener sede, (aquí se hace el ajuste en caso de existir varias)
        $sede = Sede::firstOrFail();

        // calculamos el tiempo transcurrido
        $entrada = Carbon::parse($parkingSession->hora_entrada);
        $salida = Carbon::now();

        $minutosTotales = $entrada->diffInMinutes($salida);

        $horas = intdiv($minutosTotales, 60);
        $minutos = $minutosTotales % 60;

        // Seleccionar tarifas segun tipo
        if ($vehiculo->tipo === 'CARRO') {
            $tarifaHora = $sede->tarifa_hora_carros;
            $tarifaMinuto = $sede->tarifa_minutos_carros;
        } else {
            $tarifaHora = $sede->tarifa_hora_motos;
            $tarifaMinuto = $sede->tarifa_minutos_motos;
        }

        // ahora se calcula el valor
        $valor = ($horas * $tarifaHora) + ($minutos * $tarifaMinuto);

        return view('parkingSession.edit', compact('vehiculo', 'parkingSession', 'valor', 'salida'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateParkingSessionRequest $request, ParkingSession $parkingSession)
    {
        DB::beginTransaction();
        try {
            $parkingSession = ParkingSession::with('vehiculo', 'sede')
                ->findOrFail($parkingSession->id);

            $parkingSession->update([
                'hora_salida' => $request->hora_salida,
                'valor' => $request->total,
                'estado' => 0,
            ]);

            $vehiculo = $parkingSession->vehiculo;
            $sede = $parkingSession->sede;

            if ($vehiculo->tipo === 'CARRO') {
                if ($sede->total_carros > 0) {
                    $sede->decrement('total_carros');
                }
            }
            if ($vehiculo->tipo === 'MOTO') {

                if ($sede->total_motos > 0) {
                    $sede->decrement('total_motos');
                }
            }

            DB::commit();

            return redirect()->route('sede.index')->with('success', 'Salida registrada correctamente.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->with('error', 'Error al registrar la salida');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ParkingSession $parkingSession)
    {
        //
    }
}
