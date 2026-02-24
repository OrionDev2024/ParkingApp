<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistema de gestion de parqueadero: ingreso, salida, cobro y configuracion de vehiculos.">
    <title>ParkZone - Sistema de Parqueadero</title>
    <link rel="stylesheet" href="{{ asset('css/parkzone.css') }}">
</head>
<body>
    @hasSection('hide-navbar')
    @else
        @include('partials.navbar')
    @endif

    @yield('content')

    @stack('scripts')
</body>
</html>
