<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cita;
use App\Models\Rol;

class PacienteController extends Controller
{
    public function index()
    {
        //obtener el nombre del rol con nombre pacientes
        $rol = Rol::find($rol_id = 3);
        // $rol_name = \App\Models\Rol::where('id', $rol_id)->value('name');
        //echo "rol: " . $rol;

        $pacientes = User::where('rol_id', $rol_id)->get();
        //echo "pacientes: " . $pacientes;
        return view('doctor.dashboard', compact('pacientes'));
    }


    public function create()
    {
        return view('doctor.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'telefono' => 'required|string|max:15',
            'password' => 'required|string|min:6|confirmed'
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'telefono' => $request->telefono,
            'rol_id'   => 3, // ID del rol "paciente"
        ]);

        return redirect()->route('paciente.index')->with('success', 'Paciente creado exitosamente');
    }

    public function show($id)
    {
        $paciente = User::findOrFail($id);
        return view('paciente.show', compact('paciente'));
    }

    public function edit($id)
    {
        $paciente = User::findOrFail($id);
        return view('paciente.edit', compact('paciente'));
    }

    public function update(Request $request, $id)
    {
        $paciente = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $paciente->id,
            'telefono' => 'required|string|max:15',
        ]);

        $paciente->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'telefono' => $request->telefono,
            'password' => $request->password ? bcrypt($request->password) : $paciente->password,
        ]);

        return redirect()->route('dashboard')->with('success', 'Paciente actualizado exitosamente');
    }

    public function destroy($id)
    {
        $paciente = User::findOrFail($id);
        $paciente->delete();

        return redirect()->route('paciente.index')->with('success', 'Paciente eliminado exitosamente');
    }

    public function dashboardPaciente()
    {
        $user = Auth::user();
        echo $user;
        // Verificamos que el usuario está autenticado y es paciente
        if (!$user) {
            abort(403, 'Acceso no autorizado');
        }

        // Cargar solo las citas del paciente autenticado
        $citas = Cita::with('doctor')
            ->where('paciente_id', $user->id)
            ->get();

        return view('paciente.dashboard', compact('citas'));
    }
}
