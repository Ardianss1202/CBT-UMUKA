@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@stop

@section('content')
<div class="container">
    <h2 class="mb-4">Daftar Hasil Tes</h2>

    <table id="hasilUjianTable" class="table table-bordered table-striped small-table">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Mata Pelajaran</th>
                <th class="text-center">Jumlah Soal</th>
                <th class="text-center">Waktu</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($hasilTes as $index => $hasil)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ $hasil->mapel->nama ?? '-' }}</td>
                <td class="text-center">{{ $hasil->jumlah_soal ?? '-' }}</td>
                <td class="text-center">{{ $hasil->waktu ?? '-' }} menit</td>
                <td class="text-center">
                    <a href="{{ route('hasil_ujian.show', $hasil->id) }}" class="btn btn-info btn-xs">
                        <i class="fa fa-search"> Detail Hasil Ujian</i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Tambahkan DataTables -->
@section('scripts')
<script>
    $(document).ready(function() {
        $('#hasilUjianTable').DataTable({
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "paginate": {
                    "next": "Berikutnya",
                    "previous": "Sebelumnya"
                }
            }
        });
    });
</script>
@endsection
@endsection
