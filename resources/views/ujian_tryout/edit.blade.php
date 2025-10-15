@extends('adminlte::page')

@section('title', 'Edit Ujian')

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
            <form action="{{ route('ujian_tryout.update', $ujian->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nama_ujian" class="form-label">Nama Ujian</label>
                    <input type="text" name="nama_ujian" id="nama_ujian" class="form-control @error('nama_ujian') is-invalid @enderror" 
                           value="{{ old('nama_ujian', $ujian->nama_ujian) }}" required>
                    @error('nama_ujian')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <label for="jenis" class="form-label">Jenis Ujian</label>
                    <select name="jenis" id="jenis" class="form-control @error('jenis') is-invalid @enderror" required>
                        <option value="">-- Pilih jenis --</option>
                            <option value="acak" {{ old('jawaban', $ujian->jenis ?? '') == 'acak' ? 'selected' : '' }}>
                               acak
                            </option>
                            <option value="set" {{ old('jawaban', $ujian->jenis ?? '') == 'set' ? 'selected' : '' }}>
                               set
                            </option>
                    </select>
                    @error('jenis')
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
                        value="{{ old('tgl_mulai', $ujian->tgl_mulai) }}" required>
                    @error('tgl_mulai')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <label for="terlambat" class="form-label">Tanggal Terlambat Ujian</label>
                    <input type="datetime-local" name="terlambat" id="terlambat"
                        class="form-control @error('terlambat') is-invalid @enderror"
                        value="{{ old('terlambat', $ujian->terlambat) }}" required>
                    @error('terlambat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                </div>

                <button type="submit" class="btn text-white bg-success">Simpan Perubahan</button>
                <a href="{{ route('ujian_tryout.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
