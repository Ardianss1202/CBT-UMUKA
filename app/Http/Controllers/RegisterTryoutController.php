<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterTryoutController extends Controller
{
    public function showRegisterForm()
    {
        $wajib = DB::table('m_mapel')->where('kategori','wajib')->get();
        $pilihan = DB::table('m_mapel')->where('kategori','pilihan')->get();


        return view('auth.register', compact('wajib','pilihan')); 
    }

    public function register(Request $request)
    {
        // Validasi Input
        $request->validate([
            'nama' => 'required|string|max:255',
            'sekolah' => 'required|max:200',
            'no_hp' => 'required|string|max:100',
            'mapel_wajib' => 'required|array',
            'mapel_pilihan' => 'required|array|size:2',
            'email' => 'required|email|unique:m_siswa,email',
            'password' => 'required|string|min:6'
        ]);
        
        // Gabungkan array id wajib menjadi string dipisah koma
        $mapelWajibString = implode(',', $request->mapel_wajib);
        $mapelPilihanString = implode(',', $request->mapel_pilihan);
        
        do {
            // Buat token acak huruf besar 5 karakter
            $token = strtoupper(Str::random(5));

            // Cek apakah token sudah ada di database
            $exists = DB::table('m_siswa')->where('token', $token)->exists();
        } while ($exists); // jika sudah ada, buat ulang token baru

        $token = strtoupper(Str::random(5));

        // Simpan Data ke Database
        $idSiswa = DB::table('m_siswa')->insertGetId([
            'nama' => $request->nama,
            'sekolah' => $request->sekolah,
            'no_hp' => $request->no_hp,
            'mapel_wajib' => $mapelWajibString, // ubah array jadi string,
            'mapel_pilihan' => $mapelPilihanString, // ubah array jadi string,
            'email' => $request->email,
            'token' => $token,
        ]);

        Admin::create([
            'username' => $request->email,
            'password' => Hash::make($request->password),
            'level' => 'siswa_tryout',
            'kon_id' => $idSiswa
        ]);

        // Redirect ke halaman daftar siswa dengan pesan sukses
        return redirect('/')->with('success', 'Berhasil registrasi!');
    }
}