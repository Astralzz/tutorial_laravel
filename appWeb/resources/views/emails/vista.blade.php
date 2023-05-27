{{-- TODO, Vista de el email --}}
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
</head>

{{-- * Cuerpo --}}

<body style="background-color: #f9f9f9; font-family: Arial, sans-serif;">

    <div style="background-color: #ffffff; max-width: 600px; margin: 0 auto; padding: 20px;">
        <h2 style="color: #b33b3b;">Hola, Saludos.</h2>
        <hr style="border: 1px solid #cccccc;">

        {{-- ? Existe el cuerpo --}}
        @if (isset($cuerpo))
            <p style="text-align: right;">destinatario:
                {{ isset($cuerpo['destinatario']) ? $cuerpo['destinatario'] : 'desconocido' }}
            </p>

            <hr style="border: 1px solid #cccccc;">

            <p style="text-align: right;">Mensaje:</p>
            <p style="text-align: right;">{{ isset($cuerpo['mensaje']) ? $cuerpo['mensaje'] : 'Desconocido' }}</p>
        @else
            <p style="text-align: right;">Error, no se pudo obtener el cuerpo del mensaje del email</p>
        @endif

        <hr style="border: 1px solid #cccccc;">

        <p style="text-align: center; color: #333333;">Saludos cordiales,</p>
        <p style="text-align: center; color: #333333;">Edain Jesús</p>
    </div>

</body>

</html>
