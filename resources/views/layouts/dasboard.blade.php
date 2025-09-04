@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Selamat Datang di Dashboard CBT UMUKA</h2>
    <p>Silakan pilih ujian:</p>
    <ul>
        <li><a href="#">Ujian IPA</a></li>
        <li><a href="#">Ujian IPS</a></li>
    </ul>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
    </form>
</div>
@endsection
