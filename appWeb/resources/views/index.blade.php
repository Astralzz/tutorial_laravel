<!DOCTYPE html>
<html lang="en">
{{-- TODO, Encabezado --}}

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <style>
        .container {
            margin-top: 20px;
        }

        .form-container {
            margin-top: 40px;
        }

        .color-rojo {
            color: brown;
        }

        .color-amarillo {
            color: rgb(201, 158, 80);
        }
    </style>
</head>

{{-- TODO, Cuerpo --}}

<body>
    {{-- * ------------------------------------------ --}}
    {{-- * Barra del menu --}}
    <nav>
        <div class="nav-wrapper">
            <a href="{{ route('index') }}" class="brand-logo">Usuarios</a>
        </div>
    </nav>

    {{-- * ------------------------------------------ --}}
    {{-- * Lista de usuarios --}}

    {{-- ? No existe --}}
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
        {{-- * Lista de usuarios --}}
        @include('pages.lista')
    @endif

    <hr>

    {{-- * ------------------------------------------ --}}
    {{-- * Registro de usuarios --}}
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

    {{-- * ------------------------------------------ --}}
    {{-- * Scrips --}}

    {{-- MATERIAL DESAIN --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    {{-- LOGICA DE JS --}}
    <script>
        // Referencia
        function refModal() {
            const modal = document.querySelector('#modal1');
            if (!modal) {
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

                // Nombre
                const nombre =
                    `${usuario.nombre ?? "???"} ${usuario.apellido_paterno ?? "???"} ${usuario.apellido_materno ?? "???"}`;

                // Ponemos los datos
                document.getElementById('emailDestino').value = usuario.email;
                document.getElementById('destinatario').value = nombre;
            }
        });
    </script>


</body>
