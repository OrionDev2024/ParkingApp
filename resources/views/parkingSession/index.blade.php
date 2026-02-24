@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-content">

        <div class="page-header">
            <a href="{{ route('sede.index') }}" class="btn-back" aria-label="Volver">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m12 19-7-7 7-7"/><path d="M19 12H5"/>
                </svg>
            </a>
            <h2>Vehiculos registrados</h2>
        </div>

        @if($parkingSessions->isEmpty())
            <div class="empty-state">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/>
                    <polyline points="14 2 14 8 20 8"/>
                </svg>
                <p>No hay Vehiculos registrados.</p>
            </div>
        @else
            {{-- Desktop header --}}
            <div class="vehiculos-header">
                <span>Vehiculo</span>
                <span>Tipo</span>
                <span>Entrada</span>
                <span>Salida</span>
                <span style="text-align: right;">Valor</span>
            </div>

            @foreach($parkingSessions as $parkingSession)
                <div class="vehiculo-row">
                    {{-- Placa --}}
                    <div class="vehiculo-row-placa">
                        <div class="vehiculo-row-icon">
                            {{-- @if($parkingSession->vehiculo->tipo === 'CARRO')
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/>
                                    <circle cx="7" cy="17" r="2"/><circle cx="17" cy="17" r="2"/>
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="18.5" cy="17.5" r="3.5"/><circle cx="5.5" cy="17.5" r="3.5"/>
                                    <circle cx="15" cy="5" r="1"/><path d="M12 17.5V14l-3-3 4-3 2 3h2"/>
                                </svg>
                            @endif --}}
                        </div>
                        <span class="placa">{{ $parkingSession->vehiculo->placa }}</span>
                    </div>

                    {{-- Tipo --}}
                    <div class="vehiculo-row-field">
                        <span class="mobile-label">Tipo:</span>
                        <span style="text-transform: capitalize;">{{ $parkingSession->vehiculo->tipo }}</span>
                    </div>

                    {{-- Entrada --}}
                    <div class="vehiculo-row-field">
                        <span class="mobile-label">Entrada:</span>
                        <span class="text-mono">{{ $parkingSession->hora_entrada->format('h:i:s A') }}</span>
                    </div>

                    {{-- Salida --}}
                    <div class="vehiculo-row-field">
                        <span class="mobile-label">Salida:</span>
                        @if($parkingSession->hora_salida)
                            <span class="text-mono">{{ $parkingSession->hora_salida->format('h:i:s A') }}</span>
                        @else
                            <span class="badge-active">En parqueadero</span>
                        @endif
                    </div>

                    {{-- Precio --}}
                    <div class="vehiculo-row-field" style="justify-content: flex-end;">
                        <span class="mobile-label">Valor:</span>
                        @if($parkingSession->valor !== null)
                            <span class="text-mono text-semibold">${{ number_format($parkingSession->valor, 0, ',', '.') }}</span>
                        @else
                            <span class="text-muted">--</span>
                        @endif
                    </div>
                </div>
                <br>
            @endforeach
        @endif

    </div>
</div>
@endsection
