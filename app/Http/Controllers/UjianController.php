<?php

namespace App\Http\Controllers;

use App\Models\GuruTes;
use App\Models\IkutUjian;
use App\Models\Mapel;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class UjianController extends Controller
{
    public function daftar_ujian()
    {
        return view('ujian.ujian');
    }

    public function konfirmasi_ujian(Request $request)
    {
        $ujian = GuruTes::where('token', $request->get('token'))->first();

        // Jika token tidak cocok atau tidak ditemukan
        if (!$ujian) {
            return redirect()->route('daftar_ujian')
                ->withErrors(['token' => 'Token tidak ditemukan atau tidak valid.']);
        }

        // Baru setelah valid, simpan ke session
        Session::put('id_mapel', $ujian->id_mapel);
        Session::put('id_ujian', $ujian->id);

        $mapel = Mapel::findOrFail($ujian->id_mapel);        
        $siswa = Siswa::findOrFail(session('kon_id'));

        $now = Carbon::now();
        $mulai = Carbon::parse($ujian->tgl_mulai);
        $terlambat = Carbon::parse($ujian->terlambat);

        if ($now->between($mulai, $terlambat)) {
            $status = 'Sudah dimulai';
        } elseif ($now->greaterThan($terlambat)) {
            $status = 'Waktu Habis';
        } else {
            $status = 'Belum Dimulai';
        }

        $token = $request->get('token');
        return view('ujian.konfirmasi_ujian', compact('siswa', 'mapel', 'ujian', 'status', 'mulai', 'terlambat', 'token'));
    }


    public function generateToken($id)
    {
        $token = strtoupper(Str::random(5));
        DB::table('tr_guru_tes')->where('id', $id)->update(['token' => $token]);

        return redirect()->route('ujian.index')->with('success', 'Token berhasil diperbarui.');
    }

    public function mulai_ujian()
    {
        
        $idMapel = session('id_mapel');

        $ujian = GuruTes::where('id_mapel', $idMapel)->first();
        $soals = DB::table('m_soal')
        ->where('id_mapel', $idMapel)
        ->paginate(10);

        $waktu_mulai = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');

        return view('ujian.mulai_ujian', compact('soals','ujian', 'waktu_mulai'));
    }

    public function cekToken(Request $request)
    {
        $idTes = $request->input('id_ujian');
        $tokenInput = strtoupper(trim($request->input('token')));

        $ujian = GuruTes::find($idTes);

        return response()->json(['valid' => $ujian && $ujian->token === $tokenInput]);
    }

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

    public function submitJawaban(Request $request)
    {
        $jawaban = $request->jawaban ?? [];

        $keys = array_keys($jawaban);
        $listSoalString = implode(',', $keys);

        $jawabanString = implode(',', array_map(
            fn($key, $value) => "$key:$value",
            array_keys($jawaban),
            $jawaban
        ));

        $idMapel = session('id_mapel');
        $kon_id = session('kon_id');
        $idUjian = session('id_ujian');

        $soals = DB::table('m_soal')->where('id_mapel', $idMapel)->get();

        $jml_benar = 0;
        foreach ($soals as $soal) {
            foreach ($jawaban as $key => $jawab) {
                if ($soal->id == $key) {
                    if ($soal->jawaban == $jawab) {
                        $jml_benar += 1;
                    }
                }
            }
        }

        if ($jml_benar >= 1 ) {
            $status = 'lulus';
        }else{
            $status = 'tidak lulus';
        }

        $waktu_selesai = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');

        DB::table('tr_ikut_ujian')->insert([
                'id_tes' => $idUjian,
                'id_user' => $kon_id,
                'list_soal' => $listSoalString,
                'list_jawaban' => $jawabanString,
                'jml_benar' => $jml_benar,
                'nilai' => 0,
                'nilai_bobot' => 0,
                'status_lulus' => $status,
                'tgl_mulai' => $request->get('waktu_mulai'),
                'tgl_selesai' => $waktu_selesai,
            ]);
            
        if ($status == 'lulus') {
            return view('ujian.lolos_ujian_page');
        } else {
            return view('ujian.gagal_ujian_page');
        }    
    }

    public function index(Request $request)
    {
        $query = Siswa::query();    

        $query = GuruTes::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama_ujian', 'like', "%$search%");
        }

        $ujians = $query->paginate(10);

        return view('ujian.index', compact('ujians'));
    }

    public function edit($id)
    {
        $ujian = GuruTes::with('mapel')->where('id', $id)->firstOrFail();
        $mapels = Mapel::all();
        return view('ujian.edit', compact('ujian', 'mapels'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'id_mapel' => 'required|exists:m_mapel,id',
            'waktu' => 'required|integer|min:1',
            'tgl_mulai' => 'required|date',
            'tgl_terlambat' => 'required|date|after_or_equal:tgl_mulai',
        ]);
        
        DB::table('tr_guru_tes')->where('id', $id)->update([
            'nama_ujian' => $request->nama,
            'id_mapel' => $request->id_mapel,
            'waktu' => $request->waktu,
            'tgl_mulai' => $request->tgl_mulai,
            'terlambat' => $request->tgl_terlambat,
        ]);

        return redirect()->route('ujian.index')->with('success', 'Data ujian berhasil diperbarui.');
    }

}
