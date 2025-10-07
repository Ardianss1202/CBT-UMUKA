<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Siswa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Menampilkan halaman login
    public function showLoginForm()
    {
        return view('auth.login'); 
    }

    // Proses login
    public function login(Request $request)
{
    $request->validate([
        'username' => 'required|string',
        'password' => 'required',
    ]);

    // Cari user berdasarkan username
    $admin = Admin::where('username', $request->username)->first();

    // Cek apakah user ditemukan dan password cocok
    if ($admin && Hash::check($request->password, $admin->password)) {
        Auth::login($admin);
        $request->session()->regenerate();

        if ($admin->level == 'siswa_tryout') {
            $nama = DB::table('m_siswa_tryout')
                        ->where('id', $admin->kon_id)
                        ->value('nama');
        } elseif ($admin->level == 'siswa') {
            $nama = Siswa::where('id', $admin->kon_id)->value('nama');
        } else {
            $nama = 'admin';
        }
        Session::put('kon_id', $admin->kon_id);
        Session::put('nama', $nama);
        Session::put('level', $admin->level);

        // Redirect berdasarkan level/role
        if ($admin->level === 'admin') {
            return redirect()->route('dashboard');
        } elseif ($admin->level === 'siswa') {
            return redirect()->route('dashboard_user');
        } elseif ($admin->level === 'siswa_tryout') {
            return redirect()->route('dashboard_user_tryout');
        } else {
            Auth::logout();
            return back()->withErrors([
                'username' => 'Role tidak dikenali.',
            ]);
        }
    }

    return back()->withErrors([
        'username' => 'Username atau password salah.',
    ])->onlyInput('username');
}


    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
