<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogOutController extends Controller
{
    public function index(Request $request)
    {
        $request->session()->forget(['user']);
        return redirect()->route('Login');
    }
}
