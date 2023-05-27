{{-- TODO, Lista de usuarios --}}

{{-- ? La lista esta vacia --}}
@if ($lista->isEmpty())
    <div class="container form-container">
        <div class="row">
            <div class="col s12">
                <div class="error-message color-amarillo">
                    <h4>La lista de usuarios esta vacia</h4>
                </div>
            </div>
        </div>
    </div>
@else
    {{-- * Lista --}}
    <div class="container">
        <div class="row">
            <div class="col s12">

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

                {{-- Titulo --}}
                <h4>Lista de Usuarios</h4>

                {{-- Coleccion --}}
                <ul class="collection">
                    {{-- Recorremos --}}
                    @foreach ($lista as $usuario)
                        @php
                            $nombreCompleto = $usuario->nombre . ' ' . $usuario->apellido_paterno . ' ' . $usuario->apellido_materno;
                        @endphp

                        {{-- Ponemos datos --}}
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
                                {{-- Enviar email --}}
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

        {{-- * MODAL PARA ENVIAR EL EMAIL --}}
        <div id="modal1" class="modal">
            <div class="modal-content">
                <h5>Enviar Email</h5>
                <form action="{{ route('enviar.email') }}" method="POST">
                    @csrf

                    {{-- Oculto --}}
                    <input type="hidden" name="emailDestino" id="emailDestino">
                    <input type="hidden" name="destinatario" id="destinatario">

                    {{-- Mensaje --}}
                    <div class="form-floating">
                        <textarea class="form-control" placeholder="Escribe tu mensaje" name="mensaje" id="mensajeModal" required
                            style="height: 100px"></textarea>
                        <label for="mensajeModal">Mensaje</label>
                    </div>

                    <br>

                    {{-- Boton --}}
                    <button type="submit" class="btn">Enviar</button>
                </form>
            </div>
        </div>
    </div>
@endif
