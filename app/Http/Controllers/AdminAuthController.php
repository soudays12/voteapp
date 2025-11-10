<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    
    public function login(Request $request){
        return view('dashboard.login');
    }
    
    //authentification
    public function authenticate(Request $request) {
        // Valider la requête entrante
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Tenter d'authentifier l'utilisateur
        try {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                // L'authentification a réussi, rediriger vers la page d'accueil
                return redirect()->route('dashboard')->with('success', 'Connexion réussie !');
            }

            // Si l'authentification échoue
            return redirect()->back()->withErrors([
                'email' => 'Erreur de connexion, vérifiez votre email ou votre mot de passe',
            ])->withInput($request->only('email'));

        } catch (QueryException $e) {
            // Gérer les exceptions SQL ici
            return redirect()->back()->withErrors([
                'email' => 'Une erreur est survenue lors de la connexion. Veuillez réessayer plus tard.',
            ])->withInput($request->only('email'));
        } catch (\Exception $e) {
            // Gérer d'autres exceptions générales
            return redirect()->back()->withErrors([
                'email' => 'Une erreur inattendue est survenue. Veuillez réessayer.',
            ])->withInput($request->only('email'));
        }
    }


    //page d'inscription de l'utilisateur
    public function inscription(){
        return view('dashboard.inscription');
    }

    //deconnexion
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('dashboard');
    }

    
}

