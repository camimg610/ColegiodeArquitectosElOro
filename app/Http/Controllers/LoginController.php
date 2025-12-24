<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        return view('login.login');
    }

    /**
     * Handle login attempt
     */
    public function login(Request $request)
    {
        // Validar los campos del formulario
        $credentials = $request->validate([
            'usuario' => 'required|string',
            'password' => 'required|string',
        ]);

        // Buscar el usuario por nombre de usuario
        $user = User::where('Usuario', $credentials['usuario'])
                   ->where('Activo', true)
                   ->first();

        // Verificar si el usuario existe y la contraseña es correcta
        if (!$user || !Hash::check($credentials['password'], $user->Contraseña)) {
            throw ValidationException::withMessages([
                'usuario' => [__('auth.failed')],
            ]);
        }

        // Autenticar al usuario
        Auth::login($user, $request->filled('remember'));

        // Registrar el inicio de sesión
        $this->logAudit('LOGIN', $user->Cedula, 'Inicio de sesión exitoso');

        // Redirigir al dashboard
        return redirect()->intended(route('inicio'));
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $this->logAudit('LOGOUT', $user->Cedula, 'Cierre de sesión');
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    /**
     * Log audit activity
     */
    private function logAudit($operation, $cedulaUsuario = null, $description = '')
    {
        try {
            DB::table('AUDITORIA')->insert([
                'tabla_afectada' => 'USUARIO',
                'operacion' => $operation,
                'cedula_usuario' => $cedulaUsuario,
                'datos_nuevos' => json_encode(['descripcion' => $description]),
                'ip_address' => request()->ip(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Exception $e) {
            // Si falla el log de auditoría, no interrumpir el flujo principal
            Log::error('Error logging audit: ' . $e->getMessage());
        }
    }
}