<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Event;
use App\Models\Inscription;
use App\Models\Rental;
use Illuminate\Support\Facades\Hash;

class InicioController extends Controller
{
    /**
     * Show the dashboard
     */
    public function index()
    {
        $user = Auth::user();

        // Si no hay usuario autenticado, crear uno temporal
        if (!$user) {
            $user = User::where('Activo', true)->first();
            if ($user) {
                Auth::login($user);
            } else {
                // Crear usuario temporal si no hay ninguno
                $user = User::create([
                    'Cedula' => 999999999,
                    'Nombre' => 'Usuario',
                    'Apellido' => 'Temporal',
                    'Direccion' => 'Dirección Temporal',
                    'Email' => 'temp@example.com',
                    'Usuario' => 'temp_user',
                    'Contraseña' => Hash::make('temp123'),
                    'Activo' => true,
                ]);
                Auth::login($user);
            }
        }

        // Obtener estadísticas básicas
        $stats = [
            'total_usuarios' => User::where('Activo', true)->count(),
            'total_eventos' => Event::count(),
            'total_inscripciones' => Inscription::where('estado', true)->count(),
            'total_alquileres' => Rental::count(),
        ];

        return view('inicio.inicio', compact('user', 'stats'));
    }
}

