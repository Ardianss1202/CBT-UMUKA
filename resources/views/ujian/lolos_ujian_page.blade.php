@extends('layouts.app')

@section('content')
<div class="container text-center mt-5">
    <div class="alert alert-success">
        <h1 class="display-4">🎉 Selamat!</h1>
        <p class="lead">Kamu <strong>LOLOS</strong> ujian ini.</p>
        <hr>
        <p>Terus pertahankan prestasimu dan semangat belajar! 💪</p>
        <a href="{{ route('daftar_ujian') }}" class="btn btn-primary mt-3">Kembali ke Daftar Ujian</a>
    </div>
</div>
@endsection
