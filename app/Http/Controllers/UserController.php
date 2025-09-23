<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    // 🔹 Ambil detail user yang sedang login
    public function me(Request $request)
    {
        return response()->json([
            'status' => true,
            'user'   => $request->user()
        ]);
    }

    // 🔹 Update profil user
    public function update(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name'     => 'string|max:255',
            'username' => 'string|max:100|unique:users,username,' . $user->id,
            'bio'      => 'nullable|string|max:500',
        ]);

        $user->update($request->only(['name', 'username', 'bio']));

        return response()->json([
            'status'  => true,
            'message' => 'Profile updated successfully',
            'user'    => $user
        ]);
    }
}
