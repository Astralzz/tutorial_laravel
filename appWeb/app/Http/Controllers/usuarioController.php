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
        try {

            // * Obtenemos datos
            $lista = $this->usuario::all();

            // * Retornamos lista al index
            return view('index', ['lista' => $lista]);

            // ! Errores
        } catch (QueryException $e) {
            // ! En la query
            return view('index')
                ->with('error_detectado', 'Error de consulta, No se pudo obtener la lista, Detalles: ' . $e->getMessage());
            // ! Desconocido
        } catch (\Exception $e) {
            return view(
                'index',
            )->with('error_detectado', 'Error desconocido al buscar la noticia ->' . $e->getMessage());
        }
    }

    // * Crear nuevo usuario
    public function agregarUsuario(Request $request)
    {

        try {

            // * Validamos datos
            $request->validate(
                // * Reglas
                [
                    'nombre' => 'required|string|min:2|max:70',
                    'apellido_paterno' => 'required|string|min:2|max:70',
                    'apellido_materno' => 'required|string|min:2|max:70',
                    'email' => 'required|string|min:5|max:70',
                    'telefono' => 'nullable|string|min:10|max:10',
                ],
                // ! Mensajes de errores
                [
                    'nombre.required' => 'El campo del nombre es obligatorio.',
                    'nombre.string' => 'El campo del nombre debe ser un string.',
                    'nombre.max' => 'El campo del  nombre no debe tener más de 70 caracteres.',
                    'nombre.min' => 'El campo del nombre debe tener al menos 2 caracteres.',
                    'apellido_paterno.required' => 'El campo del del apellido paterno es obligatorio.',
                    'apellido_paterno.string' => 'El campo del apellido paterno debe ser un string.',
                    'apellido_paterno.max' => 'El campo del apellido paterno no debe tener más de 70 caracteres.',
                    'apellido_paterno.min' => 'El campo del apellido paterno debe tener al menos 2 caracteres.',
                    'apellido_materno.required' => 'El campo del del apellido materno es obligatorio.',
                    'apellido_materno.string' => 'El campo del apellido materno debe ser un string.',
                    'apellido_materno.max' => 'El campo del apellido materno no debe tener más de 70 caracteres.',
                    'apellido_materno.min' => 'El campo del apellido materno debe tener al menos 2 caracteres.',
                    'email.required' => 'El campo del email es obligatorio.',
                    'email.string' => 'El campo del email debe ser un string.',
                    'email.max' => 'El campo del email no debe tener más de 70 caracteres.',
                    'email.min' => 'El campo del email debe tener al menos 5 caracteres.',
                    'telefono.string' => 'El campo del telefono debe ser un string.',
                    'telefono.max' => 'El campo del telefono debe tener 10 caracteres.',
                    'telefono.min' => 'El campo del telefono debe tener 10 caracteres.',
                ]
            );

            // * Crear un nueva usuario
            $usuario = $this->usuario;

            // * Ponemos automático
            $usuario->nombre = $request->nombre;
            $usuario->apellido_paterno = $request->apellido_paterno;
            $usuario->apellido_materno = $request->apellido_materno;
            $usuario->email = $request->email;

            // ? Llego el telefono?
            if ($request->telefono) {
                $usuario->telefono = $request->telefono;
            }

            // * Guardamos
            $usuario->save();

            // * ÉXITO, Retornamos vista
            return redirect()->back()
                ->with('accion_detectada', 'Éxito, El usuario se creo correctamente');

            // ! Captar errores
        } catch (ValidationException $e) {
            // ! En la Validación
            return redirect()->back()
                ->with('error_accion', 'Error de validación, detalles: ' . $e->getMessage());
        } catch (QueryException $e) {
            // ! En la Consulta
            return redirect()->back()
                ->with('error_accion', 'Error de consulta, detalles: ' . $e->getMessage());
        } catch (\Exception $e) {
            // ! Otros
            return redirect()->back()
                ->with('error_accion', 'Error desconocido, detalles: ' . $e->getMessage());
        }
    }

    // * Eliminar usuario
    public function eliminarUsuario($id)
    {
        try {

            // ? Buscamos
            $usuario = $this->usuario::find($id);

            // ? No existe el usuario ?
            if (!$usuario) {
                throw new \Exception('Error, El usuario que intenta eliminar no existe');
            }

            // * Eliminamos
            $usuario->delete();

            // * ÉXITO, Retornamos vista
            return redirect()->back()
                ->with('accion_detectada', 'Éxito, El usuario se elimino correctamente');

            // ! Captar errores
        } catch (QueryException $e) {
            // ! En la Consulta
            return redirect()->back()
                ->with('error_accion', 'Error de consulta, detalles: ' . $e->getMessage());
        } catch (\Exception $e) {
            // ! Otros
            return redirect()->back()
                ->with('error_accion', 'Error desconocido, detalles: ' . $e->getMessage());
        }
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
                    "destinatario" => 'nullable|string|min:2|max:255',
                    'mensaje' => 'required|string|min:5|max:1500',
                ],
                // ! Mensajes de errores
                [
                    'emailDestino.required' => 'El campo del email de destino es obligatorio.',
                    'emailDestino.string' => 'El campo email e destino debe ser un string.',
                    'emailDestino.max' => 'El campo email de destino no debe tener más de 255 caracteres.',
                    'emailDestino.min' => 'El campo email de destino debe tener al menos 5 caracteres.',
                    'destinatario.string' => 'El campo del destinatario debe ser un string.',
                    'destinatario.max' => 'El campo del destinatario no debe tener más de 255 caracteres.',
                    'destinatario.min' => 'El campo del destinatario debe tener al menos 2 caracteres.',
                    'mensaje.required' => 'El campo mensaje es obligatorio.',
                    'mensaje.string' => 'El campo del mensaje debe ser un string.',
                    'mensaje.max' => 'El campo del mensaje no debe tener más de 1500 caracteres.',
                    'mensaje.min' => 'El campo del mensaje debe tener al menos 5 caracteres.',
                ]
            );

            // * Ponemos datos del email
            $datos = [
                'cuerpo' => [
                    'mensaje' => $request->mensaje,
                    'destinatario' => $request->destinatario ?? "desconocido",
                ],
            ];

            // * Enviamos email
            Mail::to($request->emailDestino)->send(new EnviarEmail($datos));

            // * ÉXITO, Retornamos vista
            return redirect()->back()
                ->with('accion_detectada', 'Éxito, El email se envió correctamente a ' . $request->emailDestino);

            // ! Captar errores
        } catch (ValidationException $e) {
            // ! En la Validación
            return redirect()->back()
                ->with('error_accion', 'Error de validación, detalles: ' . $e->getMessage());
        } catch (QueryException $e) {
            // ! En la Consulta
            return redirect()->back()
                ->with('error_accion', 'Error de consulta, detalles: ' . $e->getMessage());
        } catch (\Exception $e) {
            // ! Otros
            return redirect()->back()
                ->with('error_accion', 'Error desconocido, detalles: ' . $e->getMessage());
        }
    }
}
