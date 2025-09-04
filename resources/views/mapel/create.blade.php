@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
<div class="container mt-4 d-flex justify-content-center">
    <div class="card w-50">
        <div class="card-header text-white bg-primary">
            Tambah Data Mapel
        </div>
        <div class="card-body">
            <form action="{{ route('mapel.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                
                <button type="submit" class="btn text-white bg-success">Tambah Mapel</button>
                <a href="{{ route('siswa.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
