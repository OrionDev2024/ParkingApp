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
                <h2>{{$sede->nombre }}</h2>
            </div>
            @if ($errors->any())
                <div style="color: red; margin-bottom: 15px;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success" style="margin-bottom: 1rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('sede.update', $sede) }}" method="POST" class="stack">
                @csrf
                @method('PUT')

                {{-- Cupos --}}
                <div class="card sede-section">
                    <h3>Cupos disponibles</h3>
                    <div class="sede-grid">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label for="cupo_carros">Cupo de carros</label>
                            <input id="cupo_carros" name="cupo_carros" type="number" class="form-input normal-font"
                                value="{{ old('cupo_carros', $sede->cupo_carros) }}" min="0" required>
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label for="cupo_motos">Cupo de motos</label>
                            <input id="cupo_motos" name="cupo_motos" type="number" class="form-input normal-font"
                                value="{{ old('cupo_motos', $sede->cupo_motos) }}" min="0" required>
                        </div>
                    </div>
                </div>

                {{-- Tarifas --}}
                <div class="card sede-section">
                    <h3>Tarifas (COP por minuto)</h3>
                    <div class="sede-grid">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label for="tarifa_minutos_carros">Tarifa carro</label>
                            <input id="tarifa_minutos_carros" name="tarifa_minutos_carros" type="number"
                                class="form-input normal-font"
                                value="{{ old('tarifa_minutos_carros', $sede->tarifa_minutos_carros) }}" min="0"
                                required>
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label for="tarifa_minutos_motos">Tarifa moto</label>
                            <input id="tarifa_minutos_motos" name="tarifa_minutos_motos" type="number"
                                class="form-input normal-font"
                                value="{{ old('tarifa_minutos_motos', $sede->tarifa_minutos_motos) }}" min="0"
                                required>
                        </div>
                    </div>
                    <h3>Tarifas (COP por hora)</h3>
                    <div class="sede-grid">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label for="tarifa_hora_carros">Tarifa carro</label>
                            <input id="tarifa_hora_carros" name="tarifa_hora_carros" type="number"
                                class="form-input normal-font"
                                value="{{ old('tarifa_hora_carros', $sede->tarifa_hora_carros) }}" min="0" required>
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label for="tarifa_hora_motos">Tarifa moto</label>
                            <input id="tarifa_hora_motos" name="tarifa_hora_motos" type="number"
                                class="form-input normal-font"
                                value="{{ old('tarifa_hora_motos', $sede->tarifa_hora_motos) }}" min="0" required>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Guardar cambios</button>
            </form>

        </div>
    </div>
@endsection
