<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login.index');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // untuk keamanan session
            return $this->handleRedirect($request);
        }

        return $this->handleFailed($request);
    }

    public function logout(Request $request)
    {
        // Hapus semua session & logout Auth
        Session::forget('isLogin');
        Session::forget('user');
        Session::flush();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->ajax()) {
            return response()->json(['redirect' => route('login'), 'success' => true], 200);
        }

        return redirect()->route('login');
    }

    private function handleRedirect(Request $request)
    {
        $intended = redirect()->intended(route('dashboard'));

        if ($request->ajax()) {
            return response()->json([
                'redirect' => $intended->getTargetUrl(),
                'success' => true
            ], 200);
        }

        return $intended;
    }

    private function handleFailed(Request $request)
    {
        $errorMsg = 'Username atau password salah.';

        if ($request->ajax()) {
            return response()->json(['error' => $errorMsg], 401);
        }

        return back()->withErrors(['username' => $errorMsg])->withInput($request->only('username'));
    }
}
