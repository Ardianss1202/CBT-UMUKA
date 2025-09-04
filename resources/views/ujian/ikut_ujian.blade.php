@extends('layouts.app')

@section('title', 'Konfirmasi Ujian')

@section('content')
<div class="container mt-4">
    <div class="card border-info">
        <div class="card-header bg-info text-white">
            <strong>Konfirmasi Data</strong>
        </div>
        <div class="card-body d-flex flex-wrap justify-content-between">

            <!-- Bagian Kiri -->
            <div class="col-md-8">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">Nama</th>
                        <td>{{ $siswa->nama }}</td>
                    </tr>
                    <tr>
                        <th>NIM</th>
                        <td>{{ $siswa->nim }}</td>
                    </tr>
                    <tr>
                        <th>Guru / Mapel</th>
                        <td>{{ $ujian->mapel }}</td>
                    </tr>
                    <tr>
                        <th>Nama Ujian</th>
                        <td>{{ $ujian->nama_ujian }}</td>
                    </tr>
                    <tr>
                        <th>Jml Soal</th>
                        <td>{{ $ujian->jumlah_soal }}</td>
                    </tr>
                    <tr>
                        <th>Waktu</th>
                        <td>{{ $ujian->waktu }} menit</td>
                    </tr>
                    <tr>
                        <th>Token</th>
                        <td>
                            <input type="text" class="form-control" id="token" name="token" placeholder="Masukkan token">
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Bagian Kanan -->
            <div class="col-md-3">
                <div class="alert alert-info text-center">
                    Waktu boleh mengerjakan ujian adalah saat tombol <strong>"MULAI"</strong> berwarna hijau..!
                </div>

                <!-- Tombol default nonaktif, bisa diaktifkan dengan JS jika token benar -->
                <button class="btn btn-danger btn-block w-100" id="btnMulai" disabled>
                    Waktu Ujian Selesai
                </button>
            </div>

        </div>
    </div>
</div>
@endsection
