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

                // Loop data siswa, ambil nama mapel dari ID
        foreach ($siswas as $siswa) {
            // Ubah ID mapel wajib menjadi array
            $mapelWajibIds = explode(',', $siswa->mapel_wajib);
            $mapelPilihanIds = explode(',', $siswa->mapel_pilihan);

            // Ambil nama mapel dari tabel m_mapel_tryout
            $siswa->mapel_wajib_nama = DB::table('m_mapel')
                ->whereIn('id', $mapelWajibIds)
                ->pluck('nama')
                ->toArray();

            $siswa->mapel_pilihan_nama = DB::table('m_mapel')
                ->whereIn('id', $mapelPilihanIds)
                ->pluck('nama')
                ->toArray();
        }
    
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

        // Ubah string "1,2,3" menjadi array [1, 2, 3]
        $mapelWajibSiswa = $siswa && $siswa->mapel_wajib
            ? explode(',', $siswa->mapel_wajib)
            : [];

        $mapelPilihanSiswa = $siswa && $siswa->mapel_pilihan
            ? explode(',', $siswa->mapel_pilihan)
            : [];

        // Ambil daftar mapel dari tabel
        $mapelWajib = DB::table('m_mapel')->where('kategori', 'wajib')->get();
        $mapelPilihan = DB::table('m_mapel')->where('kategori', 'pilihan')->get();

        return view('siswa.edit', compact('siswa', 'mapelWajibSiswa', 'mapelPilihanSiswa', 'mapelWajib', 'mapelPilihan'));
    }

    public function update(Request $request, $id)
    {
        $totalMapelWajib = DB::table('m_mapel')->where('kategori', 'wajib')->count();

        $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'nullable|string|max:20|unique:m_siswa,nim,' . $id,
            'jurusan' => 'nullable|string|max:255',
            'sekolah' => 'required|string|max:50',
            'no_hp' => 'required|string|max:50',
            'mapel_wajib' => 'required|array',
            'mapel_pilihan' => 'required|array|size:2',
            'email' => 'required|email|unique:m_siswa,email,' . $id,
        ]);

        
        // Validasi tambahan: pastikan semua mapel wajib dicentang
        if (count($request->mapel_wajib) < $totalMapelWajib) {
            return back()
                ->withErrors(['mapel_wajib' => 'Semua mapel wajib harus dipilih.'])
                ->withInput();
        }

        // Gabungkan array id wajib menjadi string dipisah koma
        $mapelWajibString = implode(',', $request->mapel_wajib);
        $mapelPilihanString = implode(',', $request->mapel_pilihan);

        $siswa = Siswa::findOrFail($id);
        $siswa->update([
            'nama' => $request->nama,
            'nim' => $request->nim,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'jurusan' => $request->jurusan,
            'sekolah' => $request->sekolah,
            'mapel_wajib' => $mapelWajibString,
            'mapel_pilihan' => $mapelPilihanString,
        ]);

        if (DB::table('m_admin')->where('kon_id', $id)->value('level') == 'siswa') {
            DB::table('m_admin')->where('kon_id', $id)->update([
                'username' => $request->nim,
                'password' => Hash::make($request->nim),
            ]);
        }else if((DB::table('m_admin')->where('kon_id', $id)->value('level') == 'siswa_tryout')){
             DB::table('m_admin')->where('kon_id', $id)->update([
                'username' => $request->email,
            ]);
        }


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
