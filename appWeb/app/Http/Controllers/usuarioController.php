<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mails\EnviarEmail;
use App\Models\Usuario;
use Dotenv\Exception\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

// TODO, Controlador de los usuarios
class usuarioController extends Controller
{

    // * Usuario
    protected $usuario;

    //* Constructor
    public function __construct(Usuario $usuario)
    {
        $this->usuario = $usuario;
    }

    // * Lista de usuarios
    public function lista()
    {
        $lista = $this->usuario::all();

        return view('index', compact('lista'));
    }

    // * Buscar usuario por email
    public function enviarEmail(Request $request)
    {
        try {

            // ? Validamos datos
            $request->validate(
                // * Validaciones
                [
                    'emailDestino' => 'required|string|min:5|max:255',
                    "remitente" => 'nullable|string|min:2|max:255',
                    'mensaje' => 'required|string|min:5|max:1500',
                ],
                // ! Mensajes de errores
                [
                    'emailDestino.required' => 'El campo del email de destino es obligatorio.',
                    'emailDestino.string' => 'El campo email e destino debe ser un string.',
                    'emailDestino.max' => 'El campo email de destino no debe tener más de 255 caracteres.',
                    'emailDestino.min' => 'El campo email de destino debe tener al menos 5 caracteres.',
                    'remitente.string' => 'El campo del remitente debe ser un string.',
                    'remitente.max' => 'El campo del remitente no debe tener más de 255 caracteres.',
                    'remitente.min' => 'El campo del remitente debe tener al menos 2 caracteres.',
                    'mensaje.required' => 'El campo mensaje es obligatorio.',
                    'mensaje.string' => 'El campo del mensaje debe ser un string.',
                    'mensaje.max' => 'El campo del mensaje no debe tener más de 1500 caracteres.',
                    'mensaje.min' => 'El campo del mensaje debe tener al menos 5 caracteres.',
                ]
            );

            // * Ponemos datos del email
            $datos = [
                'remitente' => $request->remitente ?? "desconocido",
                'cuerpo' => [
                    'mensaje' => $request->mensaje,
                    'remitente' => $request->remitente ?? "0",
                ],
            ];

            // * Enviamos email
            Mail::to($request->emailDestino)->send(new EnviarEmail($datos));

            // * ÉXITO, Retornamos vista
            return response()->json([
                'estado' => true,
            ], 200);

            // ! Captar errores
        } catch (ValidationException $e) {
            // ! En la Validación
            return response()->json([
                'error' =>  'Error en la validación, error: ' . $e->getMessage()
            ], 400);
        } catch (QueryException $e) {
            // ! En la Consulta
            return response()->json([
                'error' => 'Error en la consulta, error: ' . $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
            // ! Otros
            return response()->json([
                'error' => 'Error desconocido, error: ' . $e->getMessage()
            ], 501);
        }
    }
}
