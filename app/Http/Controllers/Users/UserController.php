<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index');

    }
    public function create()
    {
        return view('users.create');
    }
    public function edit(string $id)
    {
        $user = User::with('roles')->findOrFail($id);
        
    // Obtener todos los roles desde la base de datos
    $roles = Role::pluck('name');
    
        $userRole = $user->roles->first()?->name ?? ''; // Obtiene el primer rol asignado o vacío si no tiene
    
        return view('users.edit', compact('user', 'roles', 'userRole'));
    }
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:30'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['nullable', 'string', 'min:8', 'max:9'], // Contraseña opcional
            'role' => ['required', 'string'], // El rol es obligatorio
        ]);
    
        try {
            DB::beginTransaction();
    
            $user = User::findOrFail($id); // Busca el usuario o lanza un error si no existe
    
            $user->name = Str::of($request->input('name'))->trim();
            $user->email = Str::of($request->input('email'))->trim();
    
            // Solo actualizar la contraseña si se ingresó una nueva
            if ($request->filled('password')) {
                $user->password = bcrypt($request->input('password'));
            }
    
            $user->save();
    
            // Asignar solo un rol y eliminar el anterior si existía
            $user->syncRoles([$request->input('role')]);
    
            DB::commit();
    
            return back()->with('msg', 'Usuario actualizado con éxito.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('msg_warning', 'Error: ' . $e->getMessage());
        }
    }
}
