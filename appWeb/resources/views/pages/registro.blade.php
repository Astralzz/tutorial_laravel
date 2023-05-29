{{-- TODO, Registro de usuarios --}}
<div class="container form-container">
    <div class="row">
        <div class="col s12">
            {{-- * Titulo --}}
            <h4>Registro de Usuarios</h4>
            {{-- * Formulario --}}
            <form autocomplete="off" action="{{ route('nuevo.usuario') }}" method="POST">
                @csrf
                @method('POST')
                {{-- Nombre --}}
                <div class="input-field">
                    <input type="text" minlength="2" maxlength="70" name="nombre" id="nombre" required>
                    <label for="nombre">Nombre</label>
                </div>
                {{-- Apellido Paterno --}}
                <div class="input-field">
                    <input type="text" minlength="2" maxlength="70" name="apellido_paterno" id="apellido_paterno"
                        required>
                    <label for="apellido_paterno">Apellido paterno</label>
                </div>
                {{-- Apelllido Materno --}}
                <div class="input-field">
                    <input type="text" minlength="2" maxlength="70" name="apellido_materno" id="apellido_materno"
                        required>
                    <label for="apellido_materno">Apellido materno</label>
                </div>
                {{-- Email --}}
                <div class="input-field">
                    <input type="email" minlength="5" maxlength="70" name="email" id="email" required>
                    <label for="email">Email</label>
                </div>
                {{-- Telefono --}}
                <div class="input-field">
                    <input type="number" minlength="10" maxlength="10" name="telefono" id="telefono">
                    <label for="telefono">Teléfono</label>
                </div>
                {{-- * Accion --}}
                <button type="submit" class="btn">Registrar</button>
            </form>
        </div>
    </div>
</div>
