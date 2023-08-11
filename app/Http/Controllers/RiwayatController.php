<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Riwayat;

class RiwayatController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct()
     {
         $this->middleware('auth');
     }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $riwayataktivitas = activity_logs::count();
        return view('dashboard.dashboard', compact('Riwayat_Aktivitas'));

    }
}