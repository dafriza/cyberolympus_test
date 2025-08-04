<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index() : View {
        return view('login');
    }

    public function authenticate(AuthRequest $request) : RedirectResponse {
        $validatedData = $request->validated();
        
        if(Auth::attempt($validatedData)) {            
            $request->session()->regenerate();
 
            return redirect()->intended('dashboard');
        }
        
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}
