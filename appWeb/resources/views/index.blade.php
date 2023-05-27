<!DOCTYPE html>
<html lang="en">
{{-- TODO, Encabezado --}}

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Usuarios</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <style>
        .container {
            margin-top: 20px;
        }

        .form-container {
            margin-top: 40px;
        }
    </style>
</head>

{{-- TODO, Cuerpo --}}

<body>

    {{-- Barra del menu --}}
    <nav>
        <div class="nav-wrapper">
            <a href="{{ route('index') }}" class="brand-logo">Usuarios</a>
        </div>
    </nav>

    @if ($lista->isEmpty())
        <div class="error-message">
            <h4>No hay usuarios disponibles.</h4>
        </div>
    @else
        {{-- Lista de usuarios --}}
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <h4>Lista de Usuarios</h4>
                    <ul class="collection">
                        @foreach ($lista as $usuario)
                            {{-- Datos --}}
                            @php
                                $nombreCompleto = $usuario->nombre . ' ' . $usuario->apellido_paterno . ' ' . $usuario->apellido_materno;
                            @endphp

                            <li class="collection-item">
                                <div class="row">
                                    <div class="col s9">
                                        {{-- Nombre --}}
                                        {{ $nombreCompleto }}
                                        <br>
                                        {{-- Email --}}
                                        {{ $usuario->email }}
                                        {{-- Telefono --}}
                                        @if ($usuario->telefono)
                                            <br>
                                            {{ $usuario->telefono }}
                                        @endif
                                    </div>
                                    <div class="col s3">
                                        <a href="#modal1" class="secondary-content modal-trigger"
                                            datos-usuario="{{ $usuario }}">Enviar Email</a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- MODAL PARA ENVIAR EL EMAIL --}}
            <div id="modal1" class="modal">
                <div class="modal-content">
                    <h4>Enviar Email</h4>
                    <form action="{{ route('enviar.email') }}" method="POST">
                        @csrf

                        {{-- Oculto --}}
                        <input type="hidden" name="emailDestino" id="emailDestino">
                        <input type="hidden" name="remitente" id="remitente">

                        {{-- Mensaje --}}
                        <div class="input-field">
                            <input type="text" name="mensaje" id="mensajeModal" required>
                            <label for="mensaje">Mensaje</label>
                        </div>

                        {{-- Boton --}}
                        <button type="submit" class="btn">Enviar</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- ------------------------------------------------ --}}
        {{-- REHISTRAR USUARIOS --}}
        <div class="container form-container">
            <div class="row">
                <div class="col s12">
                    <h4>Registro de Usuarios</h4>
                    <form action="{{ route('enviar.email') }}" method="POST">
                        @csrf
                        <div class="input-field">
                            <input type="text" name="name" id="name" required>
                            <label for="name">Nombre</label>
                        </div>
                        <div class="input-field">
                            <input type="email" name="email" id="email" required>
                            <label for="email">Email</label>
                        </div>
                        <div class="input-field">
                            <input type="text" name="phone" id="phone" required>
                            <label for="phone">Teléfono</label>
                        </div>
                        <button type="submit" class="btn">Registrar</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- ------------------------------------------------ --}}

        {{-- MATERIAL DESAIN --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

        {{-- LOGICA DE JS --}}
        <script>
            // Referencia
            function refModal() {
                const modal = document.querySelector('#modal1');
                if (!modal) {
                    alert("No se pudo encontrar la referencia del modal");
                    return;
                }

                M.Modal.init(modal);
            }
            document.addEventListener('DOMContentLoaded', refModal);

            // Limpiar modal
            function limpiarModal() {
                const mensaje = document.getElementById('mensajeModal');
                if (!mensaje) {
                    alert("No se pudo encontrar la referencia del mensaje");
                    return;
                }

                mensaje.value = '';
            }

            // * AL enviar el email
            document.addEventListener('click', function(event) {

                // * Modal
                if (event.target.matches('.modal-trigger')) {

                    // Limpiamos
                    limpiarModal();

                    // Obtenemos y combertimos en JSON
                    const usuario = JSON.parse(event.target.getAttribute('datos-usuario'));

                    // ? Existe email
                    if (!usuario.email) {
                        alert("No se pudo encontrar el email del usuario");
                        return;
                    }

                    // ? Existe nombre
                    if (!usuario.nombre) {
                        alert("No se pudo encontrar el nombre del usuario");
                        return;
                    }

                    // Ponemos los datos
                    document.getElementById('emailDestino').value = usuario.email;
                    document.getElementById('remitente').value = usuario.nombre;
                }
            });
        </script>
    @endif
</body>
