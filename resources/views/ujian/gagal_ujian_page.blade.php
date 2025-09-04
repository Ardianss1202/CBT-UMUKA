@extends('layouts.app')

@section('content')
<div class="container text-center mt-5">
    <div class="alert alert-danger">
        <h1 class="display-4">😞 Maaf!</h1>
        <p class="lead">Kamu <strong>GAGAL</strong> dalam ujian ini.</p>
        <hr>
        <p>Jangan menyerah! Terus belajar dan coba lagi di kesempatan berikutnya.</p>
        <a href="{{ route('daftar_ujian') }}" class="btn btn-secondary mt-3">Kembali ke Daftar Ujian</a>
    </div>
</div>
@endsection
