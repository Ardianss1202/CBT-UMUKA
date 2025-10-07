@extends('layouts.app')

@section('content')
<style>
    .custom-radio {
    accent-color: #0d6efd !important;
    transform: scale(1.3);
    display: inline-block;
    border: solid 1px black;
    }
</style>
<div class="container">

    <div class="alert alert-info text-center">
    Sisa waktu: <span id="timer"></span>
</div>
    <form action="{{ route('submit_jawaban') }}" method="POST" id="ujianForm">
    @csrf

    @foreach ($soals as $index => $soal)
        <div class="card mb-3">
            <div class="card-header">
                <strong>Soal {{ $soals->firstItem() + $index }}</strong>
            </div>
            <div class="card-body">
                {!! $soal->soal !!}

                @if ($soal->file)
                    <img src="{{ asset('image/gambar_soal/' . $soal->file) }}" alt="Gambar Soal" class="img-fluid mb-3">
                @endif

                @foreach (['A', 'B', 'C', 'D'] as $opsi)
                    <div class="form-check">
                        <input class="form-check-input custom-radio" type="radio" name="jawaban[{{ $soal->id }}]" value="{{ $opsi }}" required>
                        <label class="form-check-label">
                            {!! $opsi !!}. {!! str_replace(['#####', '<p>', '</p>'], '', $soal->{'opsi_' . strtolower($opsi)}) !!}
                        </label>

                    </div>
                @endforeach
            </div>
        </div>
    @endforeach  
    
    {{ $soals->links('pagination::bootstrap-5') }}

    <input type="hidden" name="waktu_mulai" value="{{$waktu_mulai}}">
    <button type="submit" class="btn btn-primary">Kirim Jawaban</button>
</form>

</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let waktuUjian = {{ $ujian->waktu }}; // waktu dalam menit
        let totalDetik = waktuUjian * 60;

        let timerDisplay = document.getElementById('timer');
        let form = document.getElementById('ujianForm');

        function updateTimer() {
            let menit = Math.floor(totalDetik / 60);
            let detik = totalDetik % 60;

            timerDisplay.textContent = `${menit.toString().padStart(2, '0')}:${detik.toString().padStart(2, '0')}`;

            if (totalDetik <= 0) {
                clearInterval(timerInterval);
                alert('Waktu habis! Jawaban Anda akan dikirim otomatis.');
                form.addEventListener('submit', function () {
                    Object.keys(localStorage).forEach(function(key) {
                        if (key.startsWith('jawaban_')) {
                            localStorage.removeItem(key);
                        }
                    });
                });
                form.submit();  // submit otomatis
            }

            totalDetik--;
        }

        updateTimer();
        let timerInterval = setInterval(updateTimer, 1000);
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('ujianForm');

        // Restore jawaban dari localStorage
        Object.keys(localStorage).forEach(function(key) {
            if (key.startsWith('jawaban_')) {
                const soalId = key.split('_')[1];
                const value = localStorage.getItem(key);
                const input = document.querySelector(`input[name="jawaban[${soalId}]"][value="${value}"]`);
                if (input) {
                    input.checked = true;
                }
            }
        });

        // Simpan jawaban ke localStorage setiap kali dipilih
        const radios = form.querySelectorAll('input[type="radio"]');
        radios.forEach(radio => {
            radio.addEventListener('change', function () {
                const name = this.name; // example: jawaban[3]
                const soalId = name.match(/\d+/)[0]; // ambil angka
                localStorage.setItem('jawaban_' + soalId, this.value);
            });
        });

        // Hapus jawaban dari localStorage saat dikirim
        form.addEventListener('submit', function () {
            Object.keys(localStorage).forEach(function(key) {
                if (key.startsWith('jawaban_')) {
                    localStorage.removeItem(key);
                }
            });
        });
    });
</script>

@endpush


@endsection
