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
        $query->where('nama', 'like', "%$search%");
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
        
    ]);

    // Simpan Data ke Database
    Mapel::create([
        'nama' => $request->nama,

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
       ]);

       $mapel = Mapel::findOrFail($id);
       $mapel->update($request->all());

       return redirect()->route('mapel.index')->with('success', 'Mapel berhasil diperbarui.');
   }

   // Menghapus mapel
   public function destroy($id)
   {
       $mapel = Mapel::findOrFail($id);
       $mapel->delete();

       return redirect()->route('mapel.index')->with('success', 'Mapel berhasil dihapus.');
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
