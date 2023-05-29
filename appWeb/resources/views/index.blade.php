<!DOCTYPE html>
<html lang="en">
{{-- TODO, Encabezado --}}

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- Titulo --}}
    <title>App ejemplo</title>
    {{-- Frameworks de estilos --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    {{-- Mis estilos --}}
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
</head>

{{-- TODO, Cuerpo --}}

<body>

    {{-- *  Barra del menu ------------- --}}
    <nav>
        <div class="nav-wrapper">
            <a href="{{ route('index') }}" class="brand-logo">Usuarios</a>
        </div>
    </nav>

    {{-- * Acciones ------------- --}}

    {{-- ? Se detecteto una accion --}}
    @if (session('accion_detectada'))
        <div class="alert alert-success" role="alert">
            {{ session('accion_detectada') }}
        </div>
    @endif

    {{-- ? Se detecteto un error en accion --}}
    @if (session('error_accion'))
        <div class="alert alert-danger" role="alert">
            {{ session('error_accion') }}
        </div>
    @endif

    {{-- * Lista de usuarios ------------- --}}

    {{-- ? No existe la lista --}}
    @if (!isset($lista))
        {{-- ! Error --}}
        <div class="container form-container">
            <div class="row">
                <div class="col s12">
                    <div class="error-message color-rojo">
                        {{-- ? Se detecto el error --}}
                        @if (isset($error_detectado))
                            <h4>{{ $error_detectado }}</h4>
                        @else
                            <h4>Error desconocido, No se pudo obtener la lista, destalles desconocidos</h4>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- * Lista  --}}
        @include('pages.lista')
        <hr>
    @endif

    {{-- *  Registro de usuarios ------------- --}}
    @include('pages.registro')

    {{-- * Scrips ------------- --}}

    {{-- LOGICA MATERIAL DESAIN --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    {{-- MI LOGICA DE JS --}}
    <script src="{{ asset('js/global.js') }}"></script>

</body>
