<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{


    public function index(Request $request)
    {
        $query = Siswa::query();
    
        // Jika ada pencarian
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama', 'like', "%$search%")
                  ->orWhere('nim', 'like', "%$search%")
                  ->orWhere('jurusan', 'like', "%$search%");
        }
    
        // Urutkan berdasarkan nama secara ascending (A-Z)
        $query->orderBy('nama', 'asc');
    
        // Ambil data dengan pagination (10 data per halaman)
        $siswas = $query->paginate(10);
    
        return view('siswa.index', compact('siswas'));
    }
    

public function create()
{
    return view('siswa.create'); 
}


public function store(Request $request)
{
    // Validasi Input
    $request->validate([
        'nama' => 'required|string|max:255',
        'nim' => 'required|unique:m_siswa,nim|max:20',
        'jurusan' => 'required|string|max:100',
    ]);

    // Simpan Data ke Database
    $siswa = Siswa::create([
        'nama' => $request->nama,
        'nim' => $request->nim,
        'jurusan' => $request->jurusan,
    ]);

    $idSiswa = $siswa->id;

    Admin::create([
        'username' => $request->nim,
        'password' => Hash::make($request->nim),
        'level' => 'siswa',
        'kon_id' => $idSiswa
    ]);

    // Redirect ke halaman daftar siswa dengan pesan sukses
    return redirect()->route('siswa.index')->with('success', 'Siswa berhasil ditambahkan!');
}



    public function edit($id)
    {
        $siswa = Siswa::find($id);
        if (!$siswa) {
            abort(404); // Jika data tidak ditemukan, tampilkan halaman 404
        }

        return view('siswa.edit', compact('siswa'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:m_siswa,nim,' . $id,
            'jurusan' => 'required|string|max:255',
        ]);

        $siswa = Siswa::findOrFail($id);
        $siswa->update([
            'nama' => $request->nama,
            'nim' => $request->nim,
            'jurusan' => $request->jurusan,
        ]);

        DB::table('m_admin')->where('kon_id', $id)->update([
            'username' => $request->nim,
            'password' => Hash::make($request->nim),
        ]);

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $siswa = Siswa::find($id);
    
        if (!$siswa) {
            return redirect()->route('siswa.index')->with('error', 'Data tidak ditemukan.');
        }
    
        $siswa->delete();
        return redirect()->route('siswa.index')->with('success', 'Data berhasil dihapus.');
    }

}
