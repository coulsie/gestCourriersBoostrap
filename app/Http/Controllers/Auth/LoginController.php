<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Redirection après la connexion réussie
     */
    protected $redirectTo = '/home';

    /**
     * Configuration du constructeur
     */
    public function __construct()
    {
        // On autorise la déconnexion même si la session a expiré
        $this->middleware('guest')->except('logout');
    }

    /**
     * La fonction de déconnexion (Logout)
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // On appelle explicitement la redirection personnalisée ci-dessous
        return $this->loggedOut($request) ?: redirect('/');
    }

    /**
     * ✅ LA SOLUTION : Redirection forcée vers la racine (welcome-login)
     */
    protected function loggedOut(Request $request)
    {
        return redirect('/');
    }

    /**
     * Authentification manuelle (Optionnel si vous utilisez le trait)
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended($this->redirectTo);
        }

        return back()->withErrors([
            'email' => 'Les identifiants ne correspondent pas.',
        ]);
    }
}
