<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Muestra la vista para editar el perfil
    public function edit()
    {
        $user = Auth::user();
        return view('perfil.edit', compact('user'));
    }

    // Actualiza la información del perfil
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|numeric',
            'password' => 'nullable|string|min:8|confirmed',
            'signature' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Actualizar los datos del usuario
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        // Subir y almacenar la firma si se proporciona
        if ($request->hasFile('signature')) {
            // Eliminar la firma anterior si existe
            if ($user->signature) {
                Storage::delete('public/' . $user->signature);
            }

            // Guardar la nueva firma
            $filePath = $request->file('signature')->store('signatures', 'public');
            $user->signature = $filePath;
        }

        $user->save();

        return redirect()->route('perfil.edit')->with('success', 'Perfil actualizado correctamente.');
    }
}
