@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-content">
            <div class="stack">

                {{-- Stats --}}
                <div class="stats-grid">
                    <div class="card">
                        <div class="stat-header">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="18" height="18" x="3" y="3" rx="2" />
                                <path d="M9 17V7h4a3 3 0 0 1 0 6H9" />
                            </svg>
                            <span>Total ocupados</span>
                        </div>
                        <div class="stat-value">
                            {{ $sede->total_motos + $sede->total_carros }} <small>/ {{ $sede->cupo_motos + $sede->cupo_carros }} </small>
                        </div>
                    </div>

                    <div class="card">
                        <div class="stat-header">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2" />
                                <circle cx="7" cy="17" r="2" />
                                <circle cx="17" cy="17" r="2" />
                            </svg>
                            <span>Carros</span>
                        </div>
                        <div class="stat-value">
                            {{ $sede->total_carros }} <small>/ {{ $sede->cupo_carros }}</small>
                        </div>
                        <div class="stat-sub">
                            {{ $sede->cupo_carros }} disponible{{ $sede->cupo_carros !== 1 ? 's' : '' }}
                        </div>
                    </div>

                    <div class="card">
                        <div class="stat-header">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="18.5" cy="17.5" r="3.5" />
                                <circle cx="5.5" cy="17.5" r="3.5" />
                                <circle cx="15" cy="5" r="1" />
                                <path d="M12 17.5V14l-3-3 4-3 2 3h2" />
                            </svg>
                            <span>Motos</span>
                        </div>
                        <div class="stat-value">
                            {{ $sede->total_motos }} <small>/ {{ $sede->cupo_motos }}</small>
                        </div>
                        <div class="stat-sub">
                            {{ $sede->cupo_motos }} disponible{{ $sede->cupo_motos !== 1 ? 's' : '' }}
                        </div>
                    </div>
                </div>

                {{-- Capacity bars --}}
                <div class="card capacity-section">
                    <h3>Ocupacion</h3>
                    <div class="capacity-row">
                        <div class="capacity-label">
                            <span>Carros</span>
                            <span>{{ $sede->total_carros }}/{{ $sede->cupo_carros }}</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill primary"
                                style="width: {{ $sede->cupo_carros > 0 ? ($sede->total_carros / $sede->cupo_carros) * 100 : 0 }}%">
                            </div>
                        </div>
                    </div>
                    <div class="capacity-row">
                        <div class="capacity-label">
                            <span>Motos</span>
                            <span>{{ $sede->total_motos }}/{{ $sede->cupo_motos }}</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill accent"
                                style="width: {{ $sede->cupo_motos > 0 ? ($sede->total_motos / $sede->cupo_motos) * 100 : 0 }}%">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Action buttons --}}
                <div class="actions-grid">
                    <a href="{{ route('parkingSession.create') }}" class="action-card">
                        <div class="action-card-left">
                            <div class="action-icon primary">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 12h14" />
                                    <path d="m12 5 7 7-7 7" />
                                </svg>
                            </div>
                            <div class="action-text">
                                <strong>Registrar ingreso</strong>
                                <small>Nuevo vehiculo</small>
                            </div>
                        </div>
                        <svg class="action-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14" />
                            <path d="m12 5 7 7-7 7" />
                        </svg>
                    </a>

                    <a href="{{ route('parkingSession.editar') }}" class="action-card">
                        <div class="action-card-left">
                            <div class="action-icon accent">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 12H5" />
                                    <path d="m12 19-7-7 7-7" />
                                </svg>
                            </div>
                            <div class="action-text">
                                <strong>Registrar salida</strong>
                                <small>Cobrar vehiculo</small>
                            </div>
                        </div>
                        <svg class="action-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14" />
                            <path d="m12 5 7 7-7 7" />
                        </svg>
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection
