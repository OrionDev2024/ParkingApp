<?php

namespace App\Http\Controllers;

use App\Models\Sede;
use App\Http\Requests\StoreSedeRequest;
use App\Http\Requests\UpdateSedeRequest;
use Illuminate\Support\Facades\DB;

class SedeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sede = Sede::firstOrFail();
        return view('sedes.index', compact('sede'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sede = Sede::firstOrFail();
        // dd($sede);
        return view('sedes.edit', compact('sede'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSedeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Sede $sede)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sede $sede)
    {
        // return view('sedes.edit', compact($sede));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSedeRequest $request, Sede $sede)
    {
        try {
            DB::beginTransaction();

            $sede->update($request->validated());

            DB::commit();

            return redirect()->route('sede.create')
                ->with('success', 'Configuración actualizada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', 'Ocurrió un error al actualizar la configuración.')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sede $sede)
    {
        //
    }
}
