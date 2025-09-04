<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use App\Models\Mapel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SoalController extends Controller
{
    // Menampilkan daftar soal
    public function index()
    {
        $soals = Soal::with('mapel')->paginate(10);
        return view('soal.index', compact('soals'));
    }

      // Form tambah soal
      public function create()
      {
          $p_mapel = Mapel::all(); // atau pluck('nama', 'id') sesuai kebutuhan
          $huruf_opsi = ['a','b','c','d','e'];
      
          // untuk tampilan awal (kosong)
          $soal = new Soal();
          $data_pc = [];
      
          return view('soal.create', compact('p_mapel', 'huruf_opsi', 'soal', 'data_pc'));
      }
  
      // Simpan soal baru
      public function store(Request $request)
        {
            $tgl_input = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
            
            $request->validate([
                'id_mapel' => 'required',
                'file' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'soal' => 'required|string',
                'opsi_a' => 'required|string',
                'opsi_b' => 'required|string',
                'opsi_c' => 'required|string',
                'opsi_d' => 'required|string',
                'opsi_e' => 'required|string',
                'jawaban' => 'required|string',
            ]);

            // Simpan data awal tanpa file
            $data = $request->except('file');
            $data['tgl_input'] = $tgl_input;
            
            $soal = Soal::create($data);

            // Jika ada file, upload dan update soal
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = 'gambar_soal_' . $soal->id . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('upload/gambar_soal'), $filename);

                $soal->update([
                    'file' => $filename,
                    'tipe_file' => 'image/' . $file->getClientOriginalExtension(),
                ]);
            }

            return redirect()->route('soal.index')->with('success', 'Soal berhasil ditambahkan.');
        }



    // Menampilkan halaman edit soal
    public function edit($id)
    {
        $soal = Soal::findOrFail($id);
        $mapels = Mapel::all();
        $huruf_opsi = ['a','b','c','d','e'];
        return view('soal.edit', compact('soal', 'mapels','huruf_opsi'));
    }

    // Memperbarui soal yang sudah ada
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_mapel' => 'required',
            // 'id_guru' => 'required',
            'soal' => 'required',
            'jawaban' => 'required',
            'gambar_soal' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $soal = Soal::findOrFail($id);
        $data = $request->except('gambar_soal');

        // Upload gambar soal jika ada perubahan
        // if ($request->hasFile('gambar_soal')) {
        //     // Hapus gambar lama jika ada
        //     if ($soal->file && file_exists(public_path('upload/gambar_soal/' . $soal->file))) {
        //         unlink(public_path('upload/gambar_soal/' . $soal->file));
        //     }

        //     $file = $request->file('gambar_soal');
        //     $filename = time() . '_' . $file->getClientOriginalName();
        //     $file->move(public_path('upload/gambar_soal'), $filename);
        //     $data['file'] = $filename;
        // }

        $soal->update($data);

        return redirect()->route('soal.index')->with('success', 'Soal berhasil diperbarui.');
    }

    // Menghapus soal
    public function destroy($id)
    {
        $soal = Soal::findOrFail($id);

        // Hapus gambar jika ada
        if ($soal->file && file_exists(public_path('upload/gambar_soal/' . $soal->file))) {
            unlink(public_path('upload/gambar_soal/' . $soal->file));
        }

        $soal->delete();

        return redirect()->route('soal.index')->with('success', 'Soal berhasil dihapus.');
    }
}
