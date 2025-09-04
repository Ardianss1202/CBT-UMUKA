@extends('adminlte::page')

@section('title', 'Data Soal')

@section('content_header')
    <h1>Data Soal</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="p-2 bg-info text-white d-flex justify-content-between align-items-center">
                <b>Data Soal</b>
                <div>
                    <a class="btn btn-success btn-sm" href="{{ route('soal.create') }}">
                        <i class="fas fa-plus"></i> Tambah Data
                    </a>
                </div>
            </div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                
                <table class="table table-bordered" id="datatabel">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="50%">Soal</th>
                            <th width="15%">Mapel</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($soals as $index => $soal)
                        <tr>
                            <td>{{ ($soals->currentpage()-1) * $soals->perpage() + $loop->index + 1 }}</td>
                            <td>{!! $soal->soal !!}</td>
                            <td>{{ $soal->mapel->nama ?? '-' }}</td>

                            <td>
                                <a href="{{ route('soal.edit', $soal->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('soal.destroy', $soal->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $soals->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
