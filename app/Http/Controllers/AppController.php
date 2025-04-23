<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppController extends Controller
{
    public function storePing(Request $request)
    {
        $request->validate([
            'z' => 'required|string'
        ]);

        // Simpan timezone ke session
        session(['user_timezone' => $request->z]);

        exit();
    }
}
