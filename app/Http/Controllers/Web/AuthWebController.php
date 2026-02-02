<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthWebController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required','email'],
            'password' => ['required','string'],
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return back()->withErrors(['email' => 'Identifiants invalides'])->withInput();
        }

        // token sanctum (utile plus tard si on appelle l’API depuis le web)
        $token = $user->createToken('web')->plainTextToken;

        session()->put('api_token', $token);
        session()->put('user', $user->load('roles')->toArray());

        $roles = collect(session('user.roles'))->pluck('name');

        if ($roles->contains('ADMIN')) {
            return redirect()->route('admin.dashboard');
        }
        if ($roles->contains('CUISINE')) {
            return redirect('/kitchen');
        }
        if ($roles->contains('CAISSE')) {
            return redirect('/cashier');
        }
        if ($roles->contains('SERVEUR')) {
            return redirect('/orders');
        }

        return redirect('/dashboard');
    }

    public function logout(Request $request)
    {
        session()->forget(['api_token','user']);
        return redirect()->route('login');
    }
}
