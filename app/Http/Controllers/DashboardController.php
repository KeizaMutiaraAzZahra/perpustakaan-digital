<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function kepala()
    {
        return view('kepala.dashboard');
    }

    public function petugas()
    {
        return view('petugas.dashboard');
    }
}
