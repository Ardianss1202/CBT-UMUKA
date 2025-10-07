<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use App\Models\Siswa;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $camaba = Siswa::all();
        $mapel = Mapel::all();
        return view('dashboard', compact('camaba','mapel')); 

    }

    public function dashboard_user()
    {
        return view('dashboard_user'); 
    }

    public function dashboard_user_tryout()
    {
        return view('dashboard_user_tryout'); 
    }
    
}
