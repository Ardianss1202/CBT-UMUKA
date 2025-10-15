@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    
@stop

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="p-2 text-white d-flex justify-content-between align-items-center" style="background-color:#254baab3">
                <h3 class="mb-0">Daftar Camaba</h3>
                <div>
                    <a href="{{route('siswa.create')}}" class="btn btn-sm" style="background-color:#18fb20; color:white">Tambah</a>
                    {{-- <button class="btn btn-sm" style="background-color:#5CB338; color:white">Download format import</button>
                    <button class="btn btn-primary btn-sm">Import</button> --}}
                </div>
            </div>

            <div class="card-body">
                <!-- Form Pencarian -->
                <form method="GET" action="" class="mb-3">

                    <div class="d-flex justify-content-end">
                        <div class="input-group w-25">
                            <input type="text" name="search" class="form-control" placeholder="Cari nama, NIM, atau jurusan..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </div>
                    </div>

                    
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead class="table">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>NIM</th>
                                <th>Jurusan</th>
                                <th>Sekolah</th>
                                <th>No hp</th>
                                <th>Email</th>
                                <th>Mapel wajib</th>
                                <th>Mapel pilihan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($siswas as $siswa)
                            <tr>
                                <td>{{ $loop->iteration + ($siswas->firstItem() - 1) }}</td>
                                <td>{{ $siswa->nama }}</td>
                                <td>{{ $siswa->nim ?? '-' }}</td>
                                <td>{{ $siswa->jurusan ?? '-' }}</td>
                                <td>{{ $siswa->sekolah }}</td>
                                <td>{{ $siswa->no_hp }}</td>
                                <td>{{ $siswa->email }}</td>
                                <td>{{ implode(', ', $siswa->mapel_wajib_nama) }}</td>
                                <td>{{ implode(', ', $siswa->mapel_pilihan_nama) }}</td>
                                <td>
                                    <a href="{{ url('/siswa/' . $siswa->id . '/edit') }}" class="btn btn-primary btn-sm">Edit</a>
                        
                                    <form action="{{ route('siswa.destroy', $siswa->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Data tidak ditemukan</td>
                            </tr>
                            @endforelse
                        </tbody>
                        
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $siswas->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection