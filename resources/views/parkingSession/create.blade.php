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
            <h2>Registrar ingreso</h2>
        </div>

        {{-- Success / Error messages --}}
        @if(session('success'))
            <div class="alert alert-success">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><line x1="15" x2="9" y1="9" y2="15"/><line x1="9" x2="15" y1="9" y2="15"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><line x1="15" x2="9" y1="9" y2="15"/><line x1="9" x2="15" y1="9" y2="15"/>
                </svg>
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('parkingSession.store') }}" method="POST" class="card" style="margin-top: 1rem;">
            @csrf

            <div class="form-group">
                <label for="placa">Placa del vehiculo</label>
                <input
                    id="placa"
                    name="placa"
                    type="text"
                    class="form-input"
                    placeholder="Ej: ABC123"
                    maxlength="7"
                    value="{{ old('placa') }}"
                    required
                >
            </div>

            <div class="form-group">
                <span class="form-label">Tipo de vehiculo</span>
                <div class="type-selector" id="type-selector">
                    <div class="type-option {{ old('tipo', 'CARRO') === 'CARRO' ? 'selected' : '' }}"
                         onclick="selectType('CARRO')" role="button" tabindex="0" aria-label="Seleccionar carro">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/>
                            <circle cx="7" cy="17" r="2"/><circle cx="17" cy="17" r="2"/>
                        </svg>
                        <span>Carro</span>
                    </div>
                    <div class="type-option {{ old('tipo') === 'MOTO' ? 'selected' : '' }}"
                         onclick="selectType('MOTO')" role="button" tabindex="0" aria-label="Seleccionar moto">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="18.5" cy="17.5" r="3.5"/><circle cx="5.5" cy="17.5" r="3.5"/>
                            <circle cx="15" cy="5" r="1"/><path d="M12 17.5V14l-3-3 4-3 2 3h2"/>
                        </svg>
                        <span>Moto</span>
                    </div>
                </div>
                <input type="hidden" name="tipo" id="tipo-input" value="{{ old('tipo', 'CARRO') }}">
            </div>

            <button type="submit" class="btn btn-primary">Registrar ingreso</button>
        </form>

    </div>
</div>
@endsection

@push('scripts')
<script>
    function selectType(tipo) {
        document.getElementById('tipo-input').value = tipo;
        var options = document.querySelectorAll('.type-option');
        options.forEach(function(opt) { opt.classList.remove('selected'); });
        if (tipo === 'CARRO') {
            options[0].classList.add('selected');
        } else {
            options[1].classList.add('selected');
        }
    }
</script>
@endpush
