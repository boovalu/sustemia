<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile.myprofile'); // Muestra la vista del perfil
    }

    public function edit()
    {
        return view('profile.edit'); // Vista para editar el perfil
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('profile.view')->with('success', 'Perfil actualizado con éxito.');
    }
}
