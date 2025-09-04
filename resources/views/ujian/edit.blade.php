@extends('adminlte::page')

@section('title', 'Edit Mapel')

@section('content_header')
    <h1>Edit Data Ujian</h1>
@stop

@section('content')
<div class="container mt-4 d-flex justify-content-center">
    <div class="card w-50">
        <div class="card-header text-white bg-primary">
            Edit Data Ujian
        </div>
        <div class="card-body">
            <form action="{{ route('ujian.update', $ujian->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Metode untuk update data --}}

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Ujian</label>
                    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" 
                           value="{{ old('nama', $ujian->nama_ujian) }}" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <label for="mapel" class="form-label">Mapel Ujian</label>
                    <select name="id_mapel" id="mapel" class="form-control @error('id_mapel') is-invalid @enderror" required>
                        <option value="">-- Pilih Mapel --</option>
                        @foreach($mapels as $mapel)
                            <option value="{{ $mapel->id }}" {{ old('id_mapel', $ujian->id_mapel) == $mapel->id ? 'selected' : '' }}>
                                {{ $mapel->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_mapel')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror


                    <label for="waktu" class="form-label">Waktu Ujian</label>
                    <input type="text" name="waktu" id="waktu" class="form-control @error('waktu') is-invalid @enderror" 
                           value="{{ old('waktu', $ujian->waktu) }}" required>
                    @error('waktu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <label for="tgl_mulai" class="form-label">Tanggal Mulai Ujian</label>
                    <input type="datetime-local" name="tgl_mulai" id="tgl_mulai"
                        class="form-control @error('tgl_mulai') is-invalid @enderror"
                        value="{{ old('tgl_mulai', \Carbon\Carbon::parse($ujian->tgl_mulai)->format('Y-m-d\TH:i')) }}" required>
                    @error('tgl_mulai')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <label for="tgl_terlambat" class="form-label">Tanggal Terlambat Ujian</label>
                    <input type="datetime-local" name="tgl_terlambat" id="tgl_terlambat"
                        class="form-control @error('tgl_terlambat') is-invalid @enderror"
                        value="{{ old('tgl_terlambat', \Carbon\Carbon::parse($ujian->terlambat)->format('Y-m-d\TH:i')) }}" required>
                    @error('tgl_terlambat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                </div>

                <button type="submit" class="btn text-white bg-success">Simpan Perubahan</button>
                <a href="{{ route('ujian.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
