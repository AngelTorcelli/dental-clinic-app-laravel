<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Cargar todas las citas con los nombres del paciente y doctor
        $citas = Cita::with(['paciente', 'doctor'])->get();
        return view('citas', compact('citas'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación básica (ajústala si usas enums u otros tipos de datos)
        $request->validate([
            'fecha' => 'required|date',
            'hora' => 'required',
            'paciente_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:users,id',
        ]);

        // Validar si ya existe una cita para esa fecha, hora y doctor
        $citaExistente = Cita::where('fecha', $request->fecha)
            ->where('hora', $request->hora)
            ->where('doctor_id', $request->doctor_id)
            ->first();

        if ($citaExistente) {
            return back()->withErrors(['hora' => 'Ya hay una cita agendada para ese horario con este doctor.'])->withInput();
        }

        // Crear cita
        $cita = new Cita();
        $cita->fecha = $request->input('fecha');
        $cita->hora = $request->input('hora');
        $cita->paciente_id = $request->input('paciente_id');
        $cita->doctor_id = $request->input('doctor_id');
        $cita->estado = 'pendiente'; // Estado por defecto

        $cita->save();

        return redirect()->back()->with('success', 'Cita creada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cita $cita)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cita $cita)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cita $cita)
    {
        $request->validate([
            'fecha' => 'required|date',
            'hora' => 'required',
            'paciente_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:users,id',
        ]);

        // Verificar si existe una cita diferente con los mismos datos
        $citaExistente = Cita::where('fecha', $request->fecha)
            ->where('hora', $request->hora)
            ->where('doctor_id', $request->doctor_id)
            ->where('id', '!=', $cita->id)
            ->first();

        if ($citaExistente) {
            return back()->withErrors(['hora' => 'Ya hay una cita agendada para ese horario con este doctor.'])->withInput();
        }

        $cita->update([
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'paciente_id' => $request->paciente_id,
            'doctor_id' => $request->doctor_id,
        ]);

        return redirect()->route('citas')->with('success', 'Cita actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cita $cita)
    {
        //
    }

    public function actualizarFechaHora(Request $request, $id)
    {
        $request->validate([
            'fecha' => 'required|date',
            'hora' => 'required'
        ]);

        $cita = Cita::findOrFail($id);

        // Validar si ya hay una cita en esa fecha/hora para el mismo doctor
        $existe = Cita::where('id', '!=', $id)
            ->where('fecha', $request->fecha)
            ->where('hora', $request->hora)
            ->where('doctor_id', $cita->doctor_id)
            ->exists();

        if ($existe) {
            return response()->json([
                'message' => 'Ya hay una cita con ese doctor en ese horario.'
            ], 422);
        }

        $cita->fecha = $request->fecha;
        $cita->hora = $request->hora;
        $cita->save();

        return response()->json(['message' => 'Cita actualizada con éxito']);
    }
}
