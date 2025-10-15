<?php

namespace App\Http\Controllers;

use App\Models\GuruTes;
use App\Models\Mapel;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class UjianTryoutController extends Controller
{
    // public function daftar_ujian()
    // {
    //     return view('ujian_tryout.ujian');
    // }

    // public function konfirmasi_ujian(Request $request)
    // {
    //     $ujian = GuruTes::where('token', $request->get('token'))->first();

    //     // Jika token tidak cocok atau tidak ditemukan
    //     if (!$ujian) {
    //         return redirect()->route('daftar_ujian')
    //             ->withErrors(['token' => 'Token tidak ditemukan atau tidak valid.']);
    //     }

    //     // Baru setelah valid, simpan ke session
    //     Session::put('id_mapel', $ujian->id_mapel);
    //     Session::put('id_ujian', $ujian->id);

    //     $mapel = Mapel::findOrFail($ujian->id_mapel);        
    //     $siswa = Siswa::findOrFail(session('kon_id'));

    //     $now = Carbon::now();
    //     $mulai = Carbon::parse($ujian->tgl_mulai);
    //     $terlambat = Carbon::parse($ujian->terlambat);

    //     if ($now->between($mulai, $terlambat)) {
    //         $status = 'Sudah dimulai';
    //     } elseif ($now->greaterThan($terlambat)) {
    //         $status = 'Waktu Habis';
    //     } else {
    //         $status = 'Belum Dimulai';
    //     }

    //     $token = $request->get('token');
    //     return view('ujian.konfirmasi_ujian', compact('siswa', 'mapel', 'ujian', 'status', 'mulai', 'terlambat', 'token'));
    // }


    public function generateToken($id)
    {
        $token = strtoupper(Str::random(5));
        DB::table('m_ujian_tryout')->where('id', $id)->update(['token' => $token]);

        return redirect()->route('ujian_tryout.index')->with('success', 'Token berhasil diperbarui.');
    }

    // public function mulai_ujian()
    // {
        
    //     $idMapel = session('id_mapel');

    //     $ujian = GuruTes::where('id_mapel', $idMapel)->first();
    //     $soals = DB::table('m_soal')
    //     ->where('id_mapel', $idMapel)
    //     ->paginate(10);

    //     $waktu_mulai = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');

    //     return view('ujian.mulai_ujian', compact('soals','ujian', 'waktu_mulai'));
    // }

    // public function cekToken(Request $request)
    // {
    //     $idTes = $request->input('id_ujian');
    //     $tokenInput = strtoupper(trim($request->input('token')));

    //     $ujian = GuruTes::find($idTes);

    //     return response()->json(['valid' => $ujian && $ujian->token === $tokenInput]);
    // }

    // public function submitJawaban(Request $request, $id)
    // {
    //     $jawaban = $request->input('jawaban', []);
    //     $id_user = session('kon_id');
    //     $jumlah_benar = 0;
    //     $total_soal = count($jawaban);

    //     DB::table('jawaban_siswa')
    //         ->where('id_user', $id_user)
    //         ->where('id_ujian', $id)
    //         ->delete();

    //     foreach ($jawaban as $id_soal => $jawaban_siswa) {
    //         $soal = DB::table('m_soal')->where('id', $id_soal)->first();
    //         $is_benar = $soal && $soal->jawaban == $jawaban_siswa;
    //         if ($is_benar) {
    //             $jumlah_benar++;
    //         }

    //         DB::table('jawaban_siswa')->insert([
    //             'id_user' => $id_user,
    //             'id_ujian' => $id,
    //             'id_soal' => $id_soal,
    //             'jawaban' => $jawaban_siswa,
    //             'created_at' => now(),
    //         ]);
    //     }

    //     $skor = $total_soal > 0 ? round(($jumlah_benar / $total_soal) * 100) : 0;
    //     $ujian = DB::table('tr_guru_tes')->where('id', $id)->first();
    //     $nilai_minimal = $ujian->nilai_minimal ?? 0;

    //     if ($skor >= $nilai_minimal) {
    //         return view('ujian.lolos_ujian_page', compact('skor', 'jumlah_benar', 'total_soal'));
    //     } else {
    //         return view('ujian.gagal_ujian_page', compact('skor', 'jumlah_benar', 'total_soal'));
    //     }
    // }

    // public function submitJawaban(Request $request)
    // {
    //     $jawaban = $request->jawaban ?? [];

    //     $keys = array_keys($jawaban);
    //     $listSoalString = implode(',', $keys);

    //     $jawabanString = implode(',', array_map(
    //         fn($key, $value) => "$key:$value",
    //         array_keys($jawaban),
    //         $jawaban
    //     ));

    //     $idMapel = session('id_mapel');
    //     $kon_id = session('kon_id');
    //     $idUjian = session('id_ujian');

    //     $soals = DB::table('m_soal')->where('id_mapel', $idMapel)->get();

    //     $jml_benar = 0;
    //     foreach ($soals as $soal) {
    //         foreach ($jawaban as $key => $jawab) {
    //             if ($soal->id == $key) {
    //                 if ($soal->jawaban == $jawab) {
    //                     $jml_benar += 1;
    //                 }
    //             }
    //         }
    //     }

    //     if ($jml_benar >= 1 ) {
    //         $status = 'lulus';
    //     }else{
    //         $status = 'tidak lulus';
    //     }

    //     $waktu_selesai = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');

    //     DB::table('tr_ikut_ujian')->insert([
    //             'id_tes' => $idUjian,
    //             'id_user' => $kon_id,
    //             'list_soal' => $listSoalString,
    //             'list_jawaban' => $jawabanString,
    //             'jml_benar' => $jml_benar,
    //             'nilai' => 0,
    //             'nilai_bobot' => 0,
    //             'status_lulus' => $status,
    //             'tgl_mulai' => $request->get('waktu_mulai'),
    //             'tgl_selesai' => $waktu_selesai,
    //         ]);
            
    //     if ($status == 'lulus') {
    //         return view('ujian.lolos_ujian_page');
    //     } else {
    //         return view('ujian.gagal_ujian_page');
    //     }    
    // }

    public function index(Request $request)
    {
        // Gunakan Query Builder ke tabel guru_tes (atau nama tabel yang sesuai)
        $query = DB::table('m_ujian_tryout');

        // Jika ada pencarian
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('nama_ujian', 'like', "%{$search}%");
        }

        // Ambil data dengan pagination
        $ujians = $query->paginate(10);

        // Kirim ke view
        return view('ujian_tryout.index', compact('ujians'));
    }

    public function create()
    {

        $huruf_opsi = ['a', 'b', 'c', 'd', 'e'];

        // Tampilkan halaman form tambah ujian
        return view('ujian_tryout.create', compact('huruf_opsi'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_ujian' => 'required|string|max:255',
            'jenis' => 'required|string',
            'waktu'      => 'required|integer',
            'tgl_mulai'  => 'required|date',
            'terlambat'=> 'required|date|after_or_equal:tgl_mulai',
        ]);

        $token = strtoupper(Str::random(5));
        // Siapkan data untuk disimpan
        $data = [
            'nama_ujian' => $request->nama_ujian,
            'jenis'      => $request->jenis,
            'waktu'      => $request->waktu,
            'tgl_mulai'  => $request->tgl_mulai,
            'terlambat'  => $request->terlambat,
            'token'      => $token
        ];

        // Simpan ke database
        DB::table('m_ujian_tryout')->insert($data);

        // Redirect kembali ke halaman index
        return redirect()->route('ujian_tryout.index')->with('success', 'Ujian berhasil ditambahkan.');
    }

    public function edit($id)
    {
        // Ambil data ujian dengan relasi mapel (pakai join manual)
        $ujian = DB::table('m_ujian_tryout')
            ->where('id', $id)
            ->first();

        // Jika data tidak ditemukan
        if (!$ujian) {
            abort(404, 'Data ujian tidak ditemukan');
        }

        return view('ujian_tryout.edit', compact('ujian'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_ujian' => 'required|string|max:255',
            'jenis' => 'required|string',
            'waktu'      => 'required|integer',
            'tgl_mulai'  => 'required|date',
            'terlambat'=> 'required|date|after_or_equal:tgl_mulai',
        ]);
        
        DB::table('m_ujian_tryout')->where('id', $id)->update([
            'nama_ujian' => $request->nama_ujian,
            'jenis'      => $request->jenis,
            'waktu'      => $request->waktu,
            'tgl_mulai'  => $request->tgl_mulai,
            'terlambat'  => $request->terlambat,
        ]);

        return redirect()->route('ujian_tryout.index')->with('success', 'Data ujian berhasil diperbarui.');
    }

    public function daftar_ujian()
    {
        return view('tryout.tryout');
    }

    public function konfirmasi_tryout(Request $request)
    {
        $token = $request->get('token');

        // $token_db = DB::table('m_siswa')
        //             ->where('id', session('kon_id'))
        //             ->value('token');

        // // Jika token tidak cocok atau tidak ditemukan
        // if ($token != $token_db) {
        //     return redirect()->route('daftar_ujian')
        //         ->withErrors(['token' => 'Token tidak ditemukan atau tidak valid.']);
        // }

        // Ambil data siswa (karena butuh mapel_wajib dan mapel_pilihan)
        $siswa = DB::table('m_siswa')
            ->where('id', session('kon_id'))
            ->first();

        // Pecah string ID mapel menjadi array
        $mapelWajibIds = array_filter(explode(',', $siswa->mapel_wajib ?? ''));
        $mapelPilihanIds = array_filter(explode(',', $siswa->mapel_pilihan ?? ''));

        // Ambil nama mapel dari tabel m_mapel
        $mapelWajib = DB::table('m_mapel')
            ->whereIn('id', $mapelWajibIds)
            ->get(['id', 'nama', 'kategori']);

        $mapelPilihan = DB::table('m_mapel')
            ->whereIn('id', $mapelPilihanIds)
            ->get(['id', 'nama', 'kategori']);

        // Tambahkan jumlah soal ke setiap mapel wajib
        foreach ($mapelWajib as $mapel) {
            $mapel->jumlah_soal = DB::table('m_soal')
                ->where('id_mapel', $mapel->id)
                ->count();
        }

        // Tambahkan jumlah soal ke setiap mapel pilihan
        foreach ($mapelPilihan as $mapel) {
            $mapel->jumlah_soal = DB::table('m_soal')
                ->where('id_mapel', $mapel->id)
                ->count();
        }

        // Hitung total soal wajib & soal pilihan
        $totalSoalWajib = DB::table('m_soal')
            ->whereIn('id_mapel', $mapelWajibIds)
            ->count();

        $totalSoalPilihan = DB::table('m_soal')
            ->whereIn('id_mapel', $mapelPilihanIds)
            ->count();

        // Tambahkan jumlah soal ke setiap mapel pilihan
        foreach ($mapelPilihan as $mapel) {
            $mapel->jumlah_soal = DB::table('m_soal')
                ->where('id_mapel', $mapel->id)
                ->count();
        }

        $totalSemuaSoal = $totalSoalWajib + $totalSoalPilihan;

        // $now = Carbon::now();
        // $mulai = Carbon::parse($tryout->tgl_mulai);
        // $terlambat = Carbon::parse($tryout->terlambat);

        // if ($now->between($mulai, $terlambat)) {
        //     $status = 'Sudah dimulai';
        // } elseif ($now->greaterThan($terlambat)) {
        //     $status = 'Waktu Habis';
        // } else {
        //     $status = 'Belum Dimulai';
        // }
        return view('tryout.konfirmasi_tryout', compact('siswa', 'mapelWajib', 'mapelPilihan', 'totalSemuaSoal'));
    }

}
