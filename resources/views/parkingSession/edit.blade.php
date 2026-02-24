@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-content">

            <div class="page-header">
                <a href="{{ route('sede.index') }}" class="btn-back" aria-label="Volver">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m12 19-7-7 7-7" />
                        <path d="M19 12H5" />
                    </svg>
                </a>
                <h2>Registrar salida</h2>
            </div>

            {{-- Search form --}}
            @if (!isset($vehiculo) && !isset($charged))
                <form action="{{ route('parkingSession.buscar') }}" method="POST" class="card">
                    @csrf
                    <div class="form-group">
                        <label for="placa-salida">Placa del vehiculo</label>
                        <div class="search-row">
                            <input id="placa-salida" name="placa" type="text" class="form-input"
                                placeholder="Ej: ABC123" maxlength="7" value="{{ old('placa', $placa ?? '') }}" required>
                            <button type="submit" class="btn btn-search">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8" />
                                    <path d="m21 21-4.3-4.3" />
                                </svg>
                                Buscar
                            </button>
                        </div>
                    </div>

                    @if (session('error'))
                        <div class="alert alert-danger" style="margin-top: 0;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="15" x2="9" y1="9" y2="15" />
                                <line x1="9" x2="15" y1="9" y2="15" />
                            </svg>
                            {{ session('error') }}
                        </div>
                    @endif
                </form>
            @endif

            {{-- vehiculo found - confirm exit --}}
            @if (isset($vehiculo) && !isset($charged))
                <div class="card" style="margin-top: 1rem;">
                    <h3
                        style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; color: var(--muted-fg); margin-bottom: 1rem;">
                        Vehiculo encontrado
                    </h3>

                    <div class="vehiculo-info">
                        <div>
                            <div class="vehiculo-placa">Placa: {{ $vehiculo->placa }}</div>
                            <div class="vehiculo-tipo">Tipo: {{ $vehiculo->tipo }}</div>
                        </div>
                    </div>

                    <div class="info-box">
                        <div class="info-row">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <polyline points="12 6 12 12 16 14" />
                            </svg>
                            Hora de entrada: <strong>{{ $parkingSession->hora_entrada->format('h:i A') }}</strong>
                        </div>
                        <div class="info-row">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <polyline points="12 6 12 12 16 14" />
                            </svg>
                            Hora de salida: <strong>{{ $salida->format('h:i A') }}</strong>
                        </div>
                        <div class="info-row">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <line x1="12" x2="12" y1="2" y2="22" />
                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                            </svg>
                            Valor estimado: <strong>${{ number_format($valor, 0, ',', '.') }}</strong>
                        </div>
                    </div>


                </div>
            @endif
            {{-- Payment step --}}
            @if (isset($vehiculo) && isset($valor))
                <div class="card" style="margin-top: 1rem;">
                    <h3 class="section-title">Cobro</h3>

                    <div class="vehiculo-info">
                        <div>
                            <div class="vehiculo-placa">Placa: {{ $vehiculo->placa }}</div>
                            <div class="vehiculo-tipo">Tipo: {{ $vehiculo->tipo }}</div>
                        </div>
                    </div>

                    <div class="price-box">
                        <small>Total a cobrar</small>
                        <div class="price">${{ number_format($valor, 0, ',', '.') }}</div>
                    </div>

                    <form action="{{ route('parkingSession.update', ['parkingSession' => $parkingSession->id]) }}"
                        method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="hora_salida" value="{{ $salida }}">
                        <input type="hidden" name="total" value="{{ $valor }}">

                        <div class="form-group">
                            <label for="pago">Monto recibido </label>
                            <input id="pago" name="monto_recibido" type="number" class="form-input"
                                min="0" required oninput="calculateChange()">
                        </div>

                        <div id="change-box" class="change-box hidden">
                            Devuelta: <strong id="change-value">$0</strong>
                        </div>

                        <div id="insufficient-box" class="insufficient-box hidden">
                            Monto insuficiente. Faltan <strong id="missing-value">$0</strong>
                        </div>

                        <button type="submit" id="btn-cobrar" class="btn btn-primary" disabled>
                            Cobrar
                        </button>
                    </form>
                </div>
            @endif

            {{-- Charged success --}}
            @if (isset($charged) && $charged === true && isset($vehiculo))
                <div class="card" style="margin-top: 1rem;">
                    <div class="success-state">
                        <div class="success-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                <polyline points="22 4 12 14.01 9 11.01" />
                            </svg>
                        </div>
                        <h3>Cobro exitoso</h3>
                        <p>
                            Vehiculo <strong
                                style="font-family: 'Courier New', monospace; letter-spacing: 0.1em;">{{ $vehiculo->placa }}</strong>
                            cobrado por <strong>${{ number_format($vehiculo->precio, 0, ',', '.') }}</strong>
                        </p>
                        @if (isset($devuelta) && $devuelta > 0)
                            <p style="font-size: 0.875rem;">
                                Devuelta: <strong
                                    style="color: var(--success);">${{ number_format($devuelta, 0, ',', '.') }}</strong>
                            </p>
                        @endif
                        <a href="{{ route('parking.salida') }}" class="btn btn-outline"
                            style="margin-top: 0.5rem; width: auto;">
                            Registrar otra salida
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection

@push('scripts')
    @if (isset($valor))
        <script>
            function calculateChange() {

                const total = {{ $valor }};
                const pagoInput = document.getElementById('pago');
                const pago = parseFloat(pagoInput.value) || 0;

                const changeBox = document.getElementById('change-box');
                const insufficientBox = document.getElementById('insufficient-box');
                const btnCobrar = document.getElementById('btn-cobrar');

                const changeValue = document.getElementById('change-value');
                const missingValue = document.getElementById('missing-value');

                if (pago >= total && pago > 0) {

                    const devuelta = pago - total;

                    changeValue.textContent = '$' + devuelta.toLocaleString('es-CO');

                    changeBox.classList.remove('hidden');
                    insufficientBox.classList.add('hidden');

                    btnCobrar.disabled = false;

                } else if (pago > 0 && pago < total) {

                    const faltan = total - pago;

                    missingValue.textContent = '$' + faltan.toLocaleString('es-CO');

                    insufficientBox.classList.remove('hidden');
                    changeBox.classList.add('hidden');

                    btnCobrar.disabled = true;

                } else {

                    changeBox.classList.add('hidden');
                    insufficientBox.classList.add('hidden');

                    btnCobrar.disabled = true;
                }
            }
        </script>
    @endif
@endpush
