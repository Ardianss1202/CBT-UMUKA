@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    
@stop

@section('content')
<div class="container">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="fas fa-edit"></i> Input Soal</h4>
        </div>
        <div class="card-body">

         @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

            <form action="{{ route('soal_tryout.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="id_mapel" class="form-label">Mata Pelajaran</label>
                    <select name="id_mapel" id="id_mapel" class="form-select" required>                        
                        <option value="">Pilih Mapel</option>
                            @foreach ($p_mapel as $mapel)                       
                                <option value="{{ $mapel->id }}">
                                    {{ $mapel->nama }}
                                </option>
                            @endforeach
                    </select>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="form-label">Gambar Soal</label>
                        <input type="file" name="file" class="form-control">
                        @if (!empty($soal->file))
                            <img src="{{ asset('upload/gambar_soal_tryout/' . $soal->file) }}" class="img-thumbnail mt-2" width="100%">
                        @endif
                    </div>
                    <div class="col-md-9">
                        <label class="form-label">Teks Soal</label>
                        <textarea class="form-control" id="editor_soal" name="soal" rows="3">
                            {{ old('soal', $soal->soal ?? '') }}
                        </textarea>
                    </div>
                </div>

                @foreach ($huruf_opsi as $idx)
                    <div class="row mb-3">
                        <div class="col-md-9">
                            <label class="form-label">Jawaban {{ $idx }}</label>
                            <div class="col-md-7">
                                <input type="text"
                                    class="form-control"
                                    name="opsi_{{ $idx }}"
                                    value="{{ old('opsi_' . $idx, $data_pc[$idx]['opsi'] ?? '') }}">
                            </div>
                        </div>
                    </div>
                @endforeach


                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Kunci Jawaban</label>
                        <select class="form-select" name="jawaban" required>
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
                    {{-- <div class="col-md-4">
                        <label class="form-label">Bobot Nilai Soal</label>
                        <input type="number" name="bobot" class="form-control" required value="{{ old('bobot', $soal->bobot ?? '') }}">
                    </div> --}}
                    {{-- <div class="col-md-4">
                        <label class="form-label">Tanggal Input</label>
                        <input type="date" name="tgl_input" class="form-control" required value="{{ old('tgl_input', $soal->tgl_input ?? '') }}">
                    </div> --}}
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('soal_tryout.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
                    <button type="submit" class="btn btn-info"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Terapkan CKEditor ke semua textarea dengan class ckeditor
        document.querySelectorAll('.ckeditor').forEach((el) => {
            CKEDITOR.replace(el.id);
        });
    });
</script>

@endsection

