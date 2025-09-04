@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Ujian</h1>
@stop

@section('content')

<div class="container">
    <!-- Card Utama -->
    <div class="card shadow-lg p-4">
        <div class="card-body">
            <div class="table-responsive">
                @if(isset($ujian))
                    <div class="col-md-8 mt-4">
                        <div class="card">
                            <table class="table">
                                <tr><th>Nama</th>
                                    <td>{{ $siswa->nama }}</td>
                                </tr>
                                <tr><th>NIM</th>
                                    <td>{{ $siswa->nim }}</td>
                                </tr>
                                <tr><th>Mapel</th>
                                    <td>{{ $mapel->nama }}</td>
                                </tr>
                                <tr><th>Nama Ujian</th>
                                    <td>{{ $ujian->nama_ujian }}</td>
                                </tr>
                                {{-- <tr><th>Jumlah Soal</th>
                                    <td>{{ $ujian->jumlah_soal }}</td>
                                </tr> --}}
                                <tr><th>Waktu</th>
                                    <td>{{ $ujian->waktu }} menit</td>
                                </tr>
                                <tr><th>tgl mulai</th>
                                    <td>{{ $ujian->tgl_mulai }}</td>
                                </tr>
                                <tr><th>tanggal terlambat</th>
                                    <td>{{ $ujian->terlambat }}</td>
                                </tr>
                                <tr><th>Status</th>
                                    <td>{{ $status }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                @endif

                @if ($status == 'Sudah dimulai')
                    <a href="{{ route('mulai_ujian') }}" class="btn btn-success">Mulai</a>
                @endif

            </div>
        </div>
    </div> <!-- End of Card Utama -->
</div> <!-- End of Container -->

@stop

@section('css')
    <style>
        .shadow-lg {
            border-radius: 10px;
            background-color: #fff;
        }
        .shadow-sm {
            border-radius: 8px;
        }
    </style>
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
