<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SoalTryoutController extends Controller
{
    // Menampilkan daftar soal
    public function index()
    {
        $soals = DB::table('m_soal_tryout')
            ->join('m_mapel_tryout', 'm_soal_tryout.id_mapel', '=', 'm_mapel_tryout.id')
            ->select('m_soal_tryout.*', 'm_mapel_tryout.nama as nama_mapel')
            ->paginate(10);

        return view('soal_tryout.index', compact('soals'));
    }


    // Form tambah soal
    public function create()
    {
        $p_mapel = DB::table('m_mapel_tryout')->get(); // ambil semua data mapel
        $huruf_opsi = ['a', 'b', 'c', 'd', 'e'];

        return view('soal_tryout.create', compact('p_mapel', 'huruf_opsi'));
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
            $data = $request->except(['_token', '_method', 'file']);
            $data['tgl_input'] = $tgl_input;

            // insert dan ambil id terakhir
            $soal_id = DB::table('m_soal_tryout')->insertGetId($data);

            // Jika ada file, upload dan update soal
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = 'gambar_soal_' . $soal_id . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('upload/gambar_soal_tryout'), $filename);

                DB::table('m_soal_tryout')
                    ->where('id', $soal_id)
                    ->update([
                        'file' => $filename,
                    ]);
            }

            return redirect()->route('soal_tryout.index')->with('success', 'Soal berhasil ditambahkan.');
        }

        // Menampilkan halaman edit soal
        public function edit($id)
        {
            // Ambil data soal berdasarkan ID
            $soal = DB::table('m_soal_tryout')->where('id', $id)->first();

            // Jika data tidak ditemukan, tampilkan error 404
            if (!$soal) {
                abort(404, 'Soal tidak ditemukan');
            }

            // Ambil semua data mapel
            $mapels = DB::table('m_mapel_tryout')->get();

            // Huruf opsi jawaban
            $huruf_opsi = ['a', 'b', 'c', 'd', 'e'];

            return view('soal_tryout.edit', compact('soal', 'mapels', 'huruf_opsi'));
        }

        // Memperbarui soal yang sudah ada
        public function update(Request $request, $id)
        {
            $request->validate([
                'id_mapel' => 'required',
                'soal' => 'required',
                'jawaban' => 'required',
                'file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Ambil data soal lama untuk cek file lama
            $soal = DB::table('m_soal_tryout')->where('id', $id)->first();

            if (!$soal) {
                abort(404, 'Soal tidak ditemukan');
            }

            $data = $request->except(['_token', '_method', 'file']);

            // Upload gambar soal jika ada file baru
            if ($request->hasFile('file')) {
                // Hapus gambar lama jika ada
                if ($soal->file && file_exists(public_path('upload/gambar_soal_tryout/' . $soal->file))) {
                    unlink(public_path('upload/gambar_soal_tryout/' . $soal->file));
                }

                $file = $request->file('file');
                $filename = 'gambar_soal_' . $soal->id . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('upload/gambar_soal_tryout'), $filename);

                $data['file'] = $filename;
            }

            // Update data ke database
            DB::table('m_soal_tryout')->where('id', $id)->update($data);

            return redirect()->route('soal_tryout.index')->with('success', 'Soal berhasil diperbarui.');
        }

    // Menghapus soal
    public function destroy($id)
    {
        // Ambil data soal untuk cek file gambar
        $soal = DB::table('m_soal_tryout')->where('id', $id)->first();

        if (!$soal) {
            abort(404, 'Soal tidak ditemukan');
        }

        // Hapus file gambar jika ada
        if ($soal->file && file_exists(public_path('upload/gambar_soal_tryout/' . $soal->file))) {
            unlink(public_path('upload/gambar_soal_tryout/' . $soal->file));
        }

        // Hapus data dari tabel
        DB::table('m_soal_tryout')->where('id', $id)->delete();

        return redirect()->route('soal_tryout.index')->with('success', 'Soal berhasil dihapus.');
    }

}
