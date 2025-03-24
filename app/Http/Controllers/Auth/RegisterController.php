<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Rol;
use App\Models\User;

use App\Models\Persona;
class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        // Obtener todos los roles de la base de datos, excepto el rol 'Administrador'
        $roles = Rol::where('desc_rol', '!=', 'Administrador')->get();
        
        // Pasarlos a la vista
        return view('auth.register', compact('roles'));
    }
    public function register(Request $request)
    {
        // Validamos los datos
        $this->validator($request->all())->validate();
    
        // Llamamos al método create que maneja la transacción
        $user = $this->create($request->all());
    
        // Redirigimos después del registro (puedes cambiar a la ruta que prefieras)
        return redirect($this->redirectTo);
    }

    
    /*
    |----------------------------------------------------------------------
    | Register Controller
    |----------------------------------------------------------------------
    |
    | Este controlador maneja el registro de nuevos usuarios así como su
    | validación y creación, insertando datos en las tablas 'personas' 
    | y 'users', y utilizando el procedimiento almacenado para crear 
    | registros correctamente.
    |
    */

    /**
     * Donde redirigir a los usuarios después del registro.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Crear una nueva instancia del controlador.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Obtener un validador para la solicitud de registro entrante.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nom' => ['required', 'string', 'max:50'],
            'ap' => ['required', 'string', 'max:50'],
            'am' => ['required', 'string', 'max:50'],
            'telefono' => ['required', 'string', 'max:15'],
            'correo' => ['required', 'string', 'email', 'max:30', 'unique:personas'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'desc_rol' => ['required', 'string', 'max:50'],
        ]);
    }
    


    /**
     * Crear una nueva persona y asociarla con un usuario.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        DB::beginTransaction(); // Iniciar la transacción en Laravel

        try {
            // Llamar al procedimiento almacenado
            DB::statement('CALL sp_register_persona(?, ?, ?, ?, ?, ?, ?)', [
                $data['nom'],  
                $data['ap'],   
                $data['am'],   
                $data['telefono'], 
                $data['correo'],  
                Hash::make($data['password']), // Encriptar la contraseña antes de enviarla
                $data['desc_rol'],  
            ]);
    
            // Obtener el ID de la persona recién creada
            $id_persona = DB::table('personas')
                ->where('correo', $data['correo'])  
                ->value('id_persona');
    
            if (!$id_persona) {
                throw new \Exception("No se pudo recuperar el ID de la persona.");
            }
    
            // Crear el usuario en la tabla 'users'
            $user = \App\Models\User::create([
                'name' => $data['nom'],  
                'email' => $data['correo'],  
                'password' => Hash::make($data['password']),
                'id_persona' => $id_persona,
            ]);
    
            DB::commit(); // Confirmar la transacción
    
            return $user;
    
        } catch (\Exception $e) {
            DB::rollBack(); // Revertir la transacción en caso de error
    
            // Registrar el error en logs de Laravel (opcional, útil para depuración)
            \Log::error('Error en el registro: ' . $e->getMessage());
    
            // Devolver un mensaje de error personalizado
            return back()->withErrors(['error' => 'Hubo un problema al registrar la persona.']);
        }
}
}
