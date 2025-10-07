@extends('layouts.app')

@section('content')

<style>
    img {
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
</style>

<div class="container">
    <div class="d-flex justify-content-center align-items-center">
        <div class="col-md-9 d-flex justify-content-center align-items-center">
            <div class="card w-50 ">
                <div class="card-header text-center">
                    <img src="/image/umuka.png" alt="Logo" width="50">
                    <h5 style='font-weight:700;'>CBT UMUKA</h5>
                </div>

        <div class="card-body">
            <form method="POST" action="{{ route('register.post') }}">
                @csrf
                
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input id="nama" type="text" class="form-control @error('nama') is-invalid @enderror" 
                               name="nama" value="{{ old('nama') }}" required autofocus>
                        @error('nama')
                            <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="sekolah" class="form-label">Sekolah</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-school"></i></span>
                        <input id="sekolah" type="text" class="form-control @error('sekolah') is-invalid @enderror" 
                               name="sekolah" value="{{ old('sekolah') }}" required autofocus>
                        @error('sekolah')
                            <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="no_hp" class="form-label">Nomor HP</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        <input id="no_hp" 
                            type="text" 
                            class="form-control @error('no_hp') is-invalid @enderror" 
                            name="no_hp" 
                            value="{{ old('no_hp') }}" 
                            required 
                            maxlength="15"
                            pattern="[0-9]+"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                            placeholder="Contoh: 081234567890">
                        @error('no_hp')
                            <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                {{-- MAPEL WAJIB --}}
                <div class="mb-3">
                                    <label class="form-label">Mapel Wajib</label>
                                    <ul>
                                        @foreach($wajib as $item)
                                            <li>{{ $item->nama }}</li>
                                            {{-- kirim id mapel wajib --}}
                                            <input type="hidden" name="mapel_wajib[]" value="{{ $item->id }}">
                                        @endforeach
                                    </ul>

                                    @error('mapel_wajib')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                </div>

                    {{-- MAPEL PILIHAN --}}
                    <div class="mb-3">
                        <label class="form-label">Mapel Pilihan (maksimal 2)</label>
                        @foreach($pilihan as $item)
                            <div class="form-check">
                                <input type="checkbox"
                                    class="form-check-input mapel-pilihan"
                                    name="mapel_pilihan[]"
                                    value="{{ $item->id }}"
                                    {{ in_array($item->id, old('mapel_pilihan', [])) ? 'checked' : '' }}>
                                <label class="form-check-label">{{ $item->nama }}</label>
                            </div>
                        @endforeach

                        @error('mapel_pilihan')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                               name="password" required>
                        @error('password')
                            <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkboxes = document.querySelectorAll('.mapel-pilihan');
        checkboxes.forEach(cb => {
            cb.addEventListener('change', function () {
                const checked = document.querySelectorAll('.mapel-pilihan:checked');
                
                // Cegah jika lebih dari 2
                if (checked.length > 2) {
                    this.checked = false;
                    alert('Maksimal hanya boleh memilih 2 mapel pilihan!');
                }
            });
        });
    });
</script>
@endsection
