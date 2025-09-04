<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\HasilUjian;
use App\Models\Guru;
use App\Models\Mapel;
use Illuminate\Support\Facades\DB;

class HasilUjianController extends Controller
{
    /**
     * Menampilkan daftar hasil ujian.
     */
    public function index()
    {
        $hasilTes = HasilUjian::with(['guru', 'mapel'])->get();
        return view('hasil_ujian.index', compact('hasilTes'));
    }

    /**
     * Menampilkan form tambah hasil ujian.
     */
    // public function create()
    // {
    //     $gurus = Guru::all();
    //     $mapels = Mapel::all();
    //     return view('hasil_ujian.create', compact('gurus', 'mapels'));
    // }

    /**
     * Menyimpan data hasil ujian baru.
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'id_guru' => 'required',
    //         'id_mapel' => 'required',
    //         'list_soal' => 'required',
    //         'list_jawaban' => 'required',
    //         'jml_benar' => 'required|integer',
    //         'nilai' => 'required|numeric',
    //         'nilai_bobot' => 'required|numeric',
    //         'tgl_mulai' => 'required|date',
    //         'tgl_selesai' => 'required|date',
    //         'status' => 'required|string'
    //     ]);

    //     HasilUjian::create($request->all());
    //     return redirect()->route('hasil_ujian.index')->with('success', 'Hasil ujian berhasil ditambahkan.');
    // }

    /**
     * Menampilkan detail hasil ujian.
     */
    public function show($id)
    {
        $hasilUjian = DB::table('tr_ikut_ujian')
                        ->join('m_siswa', 'tr_ikut_ujian.id_user', '=', 'm_siswa.id')
                        ->where('tr_ikut_ujian.id_tes', $id)
                        ->select('tr_ikut_ujian.*', 'm_siswa.nama') // ambil field dari kedua tabel
                        ->paginate(10);


        return view('hasil_ujian.detail', compact('hasilUjian'));
    }

    /**
     * Menampilkan form edit hasil ujian.
     */
    // public function edit(HasilUjian $hasilUjian)
    // {
    //     $gurus = Guru::all();
    //     $mapels = Mapel::all();
    //     return view('hasil_ujian.edit', compact('hasilUjian', 'gurus', 'mapels'));
    // }

    /**
     * Mengupdate hasil ujian.
     */
    // public function update(Request $request, HasilUjian $hasilUjian)
    // {
    //     $request->validate([
    //         'id_guru' => 'required',
    //         'id_mapel' => 'required',
    //         'list_soal' => 'required',
    //         'list_jawaban' => 'required',
    //         'jml_benar' => 'required|integer',
    //         'nilai' => 'required|numeric',
    //         'nilai_bobot' => 'required|numeric',
    //         'tgl_mulai' => 'required|date',
    //         'tgl_selesai' => 'required|date',
    //         'status' => 'required|string'
    //     ]);

    //     $hasilUjian->update($request->all());
    //     return redirect()->route('hasil_ujian.index')->with('success', 'Hasil ujian berhasil diperbarui.');
    // }

    // /**
    //  * Menghapus hasil ujian.
    //  */
    // public function destroy(HasilUjian $hasilUjian)
    // {
    //     $hasilUjian->delete();
    //     return redirect()->route('hasil_ujian.index')->with('success', 'Hasil ujian berhasil dihapus.');
    // }
}

