@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
   
@stop

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="p-2 text-white d-flex justify-content-between align-items-center" style="background-color:#254baab3">
                <h3 class="mb-0">Daftar Ujian</h3>
                <div class="d-flex gap-2 ms-auto"> 
                    <a href="{{route('ujian_tryout.create')}}" class="btn btn-sm" style="background-color:#0ee612e1; color:white">Tambah</a>
                </div>
            </div>
            

            <div class="card-body">
                <!-- Form Pencarian -->
                <form method="GET" action="" class="mb-3">

                    <div class="d-flex justify-content-end">
                        <div class="input-group w-25">
                            <input type="text" name="search" class="form-control" placeholder="Cari nama" value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </div>
                    </div>
                    
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead class="table">
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama</th>
                                <th>Waktu</th>
                                <th>Jenis</th>
                                <th>Mulai</th>
                                <th>Terlambat</th>
                                <th>Token</th>
                                <th width="30%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ujians as $ujian)
                            <tr>
                                <td>{{ $loop->iteration + ($ujians->firstItem() - 1) }}</td>
                                <td>{{ $ujian->nama_ujian }}</td>
                                <td>{{ $ujian->waktu }} menit</td>
                                <td>{{ $ujian->jenis }}</td>
                                <td>{{ $ujian->tgl_mulai }}</td>
                                <td>{{ $ujian->terlambat }}</td>
                                <td>{{ $ujian->token }}</td>
                                <td>
                                    <form action="{{ route('ujian_tryout.generateToken', $ujian->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-success">Refresh Token</button>
                                    </form>
                                    <a href="{{ url('/data-ujian-tryout/' . $ujian->id.'/edit') }}" class="btn btn-primary btn-sm">Edit</a>
                                    
                                    {{-- <form action="{{ route('ujian_tryout.destroy', $ujian->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>  --}}
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
                    {{ $ujians->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @endsection