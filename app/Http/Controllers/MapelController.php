<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class MapelController extends Controller
{
    public function index(Request $request)
{
    $query = Mapel::query();

    // Jika ada pencarian
    if ($request->has('search')) {
        $search = $request->search;
        $query->where('nama', 'like', "%$search%")
            ->orWhere('kategori', 'like', "%{$search}%");;
    }

    // Ambil data dengan pagination (10 data per halaman)
    $mapels = $query->paginate(10);

    return view('mapel.index', compact('mapels'));
}

public function create()
{
    return view('mapel.create'); 
}


public function store(Request $request)
{
    // Validasi Input
    $request->validate([
        'nama' => 'required|string|max:255',
        'kategori' => 'required|string|max:255',
        
    ]);

    // Simpan Data ke Database
    Mapel::create([
        'nama' => $request->nama,
        'kategori' => $request->kategori,
    ]);

    // Redirect ke halaman daftar siswa dengan pesan sukses
    return redirect()->route('mapel.index')->with('success', 'Mapel berhasil ditambahkan!');
}

   // Menampilkan form edit
   public function edit($id)
   {
       $mapel = Mapel::findOrFail($id);
       return view('mapel.edit', compact('mapel'));
   }

   // Menyimpan perubahan mapel
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
        ]);

        // Ambil data mapel lama (sebelum diupdate)
        $mapel = Mapel::findOrFail($id);
        $kategoriLama = strtolower($mapel->kategori);
        $kategoriBaru = strtolower($request->kategori);

        // Update data mapel di tabel m_mapel_tryout
        $mapel->update($request->all());

        // Jika kategori berubah (contoh: dari wajib -> pilihan)
        if ($kategoriLama !== $kategoriBaru) {
            // Ambil semua siswa
            $siswas = DB::table('m_siswa')->get();

            foreach ($siswas as $siswa) {
                $mapelWajib = explode(',', $siswa->mapel_wajib ?? '');
                $mapelPilihan = explode(',', $siswa->mapel_pilihan ?? '');

                // Jika mapel ini ada di daftar wajib dan berubah jadi pilihan
                if (in_array($id, $mapelWajib) && $kategoriBaru === 'pilihan') {
                    // Hapus dari wajib
                    $mapelWajib = array_diff($mapelWajib, [$id]);
                    // Tambah ke pilihan
                    $mapelPilihan[] = $id;
                }

                // Jika mapel ini ada di daftar pilihan dan berubah jadi wajib
                if (in_array($id, $mapelPilihan) && $kategoriBaru === 'wajib') {
                    // Hapus dari pilihan
                    $mapelPilihan = array_diff($mapelPilihan, [$id]);
                    // Tambah ke wajib
                    $mapelWajib[] = $id;
                }

                // Simpan hasil update ke database
                DB::table('m_siswa')
                    ->where('id', $siswa->id)
                    ->update([
                        'mapel_wajib' => implode(',', array_filter($mapelWajib)),
                        'mapel_pilihan' => implode(',', array_filter($mapelPilihan)),
                    ]);
            }
        }

        return redirect()->route('mapel.index')->with('success', 'Mapel berhasil diperbarui dan data siswa diperbarui.');
    }


   // Menghapus mapel
    public function destroy($id)
    {
        $mapel = Mapel::findOrFail($id);

        // Hapus mapel dari semua data siswa (kolom mapel_wajib dan mapel_pilihan)
        $siswas = DB::table('m_siswa')->get();

        foreach ($siswas as $siswa) {
            // Ubah string menjadi array
            $mapelWajib = array_filter(explode(',', $siswa->mapel_wajib ?? ''));
            $mapelPilihan = array_filter(explode(',', $siswa->mapel_pilihan ?? ''));

            // Hapus ID mapel yang dihapus dari kedua kolom
            $mapelWajib = array_diff($mapelWajib, [$id]);
            $mapelPilihan = array_diff($mapelPilihan, [$id]);

            // Simpan kembali ke database
            DB::table('m_siswa')
                ->where('id', $siswa->id)
                ->update([
                    'mapel_wajib' => implode(',', $mapelWajib),
                    'mapel_pilihan' => implode(',', $mapelPilihan),
                ]);
        }

        // Hapus mapel dari tabel m_mapel_tryout (model Mapel)
        $mapel->delete();

        return redirect()->route('mapel.index')->with('success', 'Mapel dan relasinya di data siswa berhasil dihapus.');
    }


    function generateExamToken($ujianId)
    {
        $token = strtoupper(Str::random(5));
        DB::table('m_mapel')->where('id', $ujianId)->update([
            'token' => $token
        ]);

        return redirect()->route('mapel.index')->with('success', 'Token Mapel berhasil diperbarui.');
    }

}
