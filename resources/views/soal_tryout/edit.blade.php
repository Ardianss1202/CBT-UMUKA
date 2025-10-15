@extends('adminlte::page')

@section('title', 'Input Soal')

@section('content')
<form action="{{ route('soal_tryout.update', $soal->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <input type="hidden" name="id" value="{{ old('id', $soal->id ?? '') }}">

    <div class="mb-3">
        <label for="id_mapel" class="form-label">Mata Pelajaran</label>
        <select name="id_mapel" id="id_mapel" class="form-control" required>
            @foreach($mapels as $mapel)
                <option value="{{ $mapel->id }}" {{ old('id_mapel', $soal->id_mapel ?? '') == $mapel->id ? 'selected' : '' }}>
                    {{ $mapel->nama }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="file" class="form-label">Gambar Soal (Opsional)</label>
        <input type="file" name="file" class="form-control">
        @if(!empty($soal->file) && file_exists(public_path('upload/gambar_soal_tryout/'.$soal->file)))
            <img src="{{ asset('upload/gambar_soal_tryout/'.$soal->file) }}" alt="Gambar Soal" class="img-thumbnail mt-2" width="200">
        @endif
    </div>

    <div class="mb-3">
        <label for="soal" class="form-label">Teks Soal</label>
        <textarea name="soal" id="soal" class="form-control" rows="3">{{ old('soal', $soal->soal ?? '') }}</textarea>
    </div>

    @foreach(['a','b','c','d','e'] as $huruf)
        <div class="mb-3">
            <label for="opsi_{{ $huruf }}" class="form-label">Jawaban {{ strtoupper($huruf) }}</label>
            <textarea name="opsi_{{ $huruf }}" id="opsi_{{ $huruf }}" class="form-control" rows="2">{{ old("opsi_$huruf", $soal->{'opsi_' . $huruf} ?? '') }}</textarea>
        </div>
    @endforeach

    <div class="mb-3">
        <label for="jawaban" class="form-label">Kunci Jawaban</label>
        <select name="jawaban" id="jawaban" class="form-control" required>
            <option disabled value="">-- Pilih Jawaban --</option>
            <option value="A" {{ old('jawaban', $soal->jawaban ?? '') == 'A' ? 'selected' : '' }}>
                A
            </option>
            <option value="B" {{ old('jawaban', $soal->jawaban ?? '') == 'B' ? 'selected' : '' }}>
                B
            </option>
            <option value="C" {{ old('jawaban', $soal->jawaban ?? '') == 'C' ? 'selected' : '' }}>
                C
            </option>
            <option value="D" {{ old('jawaban', $soal->jawaban ?? '') == 'D' ? 'selected' : '' }}>
                D
            </option>
            <option value="E" {{ old('jawaban', $soal->jawaban ?? '') == 'E' ? 'selected' : '' }}>
                E
            </option>
        </select>
    </div>

    <div class="mb-3">
        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Simpan</button>
        <a href="{{ route('soal_tryout.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Kembali</a>
    </div>
</form>
@endsection
