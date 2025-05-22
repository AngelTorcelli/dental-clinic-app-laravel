<?php

use App\Http\Controllers\CitaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PacienteController;
use App\Models\User;
use App\Models\Cita;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    //buscar el rol por id
    $rol = \App\Models\Rol::find($user->rol_id);

    if ($user->rol_id && $rol->name == 'paciente') {
        //obtener las citas del paciente

        $citas = Cita::where('paciente_id', $user->id)->with(['doctor'])->get();

        return view('paciente.dashboard', compact('citas'));
    } elseif ($user->rol_id && $rol->name == 'doctor') {
        $pacientes = User::whereHas('rol', function ($query) {
            $query->where('name', 'paciente');
        })->get();

        return view('doctor.dashboard', compact('pacientes'));
    } else {
        return view('dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');


// Route::get('/dashboard/paciente', function () {
//     return view('paciente.dashboard');
// })->middleware(['auth', 'verified', 'role:paciente'])->name('dashboard.paciente');

Route::get('/dashboard/doctor', [PacienteController::class, 'index'])
    ->middleware(['auth', 'verified', 'role:doctor'])
    ->name('dashboard.doctor');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/citas', [CitaController::class, 'index'])->middleware(['auth', 'verified'])->name('citas');

Route::post('/citas/store', [CitaController::class, 'store'])->middleware(['auth', 'verified'])->name('citas.store');

Route::get('/citas-json', function () {
    return \App\Models\Cita::with(['paciente', 'doctor'])->get()->map(function ($cita) {
        return [
            'title' => $cita->paciente->name . ' - ' . $cita->doctor->name,
            'start' => $cita->fecha . 'T' . $cita->hora,
            'end' => $cita->fecha . 'T' . $cita->hora,
            'extendedProps' => [
                'estado' => $cita->estado,
                'id' => $cita->id,
                'paciente_id' => $cita->paciente_id,
                'paciente' => $cita->paciente->name,
                'doctor' => $cita->doctor->name,

            ]
        ];
    });
});

Route::put('/fecha/{id}', [CitaController::class, 'actualizarFechaHora']);

Route::resource('paciente', PacienteController::class)
    ->middleware(['auth', 'verified', 'role:doctor'])
    ->names('paciente');


require __DIR__ . '/auth.php';
