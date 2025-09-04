@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
   
@stop

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg">        

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
                                <th>Nama Peserta</th>
                                <th>Jumlah Benar</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($hasilUjian as $hasil)
                            <tr>
                                <td>{{ $loop->iteration + ($hasilUjian->firstItem() - 1) }}</td>
                                <td>{{ $hasil->nama }}</td>
                                <td>{{ $hasil->jml_benar }}</td>
                                <td>{{ $hasil->status_lulus }}</td>
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
                    {{ $hasilUjian->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection