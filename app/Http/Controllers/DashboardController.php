<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function inded() : View {
        $user = auth()->user();
        return view('dashboard', compact('user'));
    }
}
