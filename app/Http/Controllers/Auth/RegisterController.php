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
        // Usamos una transacción para asegurar la integridad de los datos
        DB::beginTransaction();
    
        try {
            // Llamamos al procedimiento almacenado para registrar la persona y el rol
            DB::select('CALL sp_register_persona(?, ?, ?, ?, ?, ?, ?)', [
                $data['nom'],  // 'nom' para 'name'
                $data['ap'],   // 'ap' para 'last name'
                $data['am'],   // 'am' para 'middle name'
                $data['telefono'], // 'telefono' para phone number
                $data['correo'],  // 'correo' para email
                $data['password'], // 'contrasena' para password
                $data['desc_rol'],  // 'desc_rol' para role description
            ]);
    
            // Después de llamar al procedimiento, verificamos si la persona fue insertada correctamente
            $id_persona = DB::table('personas')
                ->where('correo', $data['correo'])  // Encontramos la persona por el correo
                ->value('id_persona');
    
            // Creamos el usuario en la tabla 'users' asociando el id_persona recién creado
            $user = \App\Models\User::create([
                'name' => $data['nom'],  // 'nom' como 'name'
                'email' => $data['correo'],  // 'correo' como 'email'
                'password' => Hash::make($data['password']),
                'id_persona' => $id_persona, // Asociamos el id_persona creado
            ]);
    
            // Confirmar transacción si todo salió bien
            DB::commit();
    
            return $user;
        } catch (\Exception $e) {
            // Si hubo un error, revertimos la transacción
            DB::rollBack();
            throw $e;
        }
    }
    
}
