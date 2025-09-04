@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Ujian</h1>
@stop

@section('content')

<div class="container">
    <!-- Card Utama -->
    <div class="card shadow-lg p-4">
        <div class="card-body">
            <div class="table-responsive">
                <form method="GET" action="{{ route('konfirmasi_ujian') }}">
                    <div class="mb-3">
                        <label for="token" class="form-label">Masukkan Token Ujian</label>
                        <input type="text" name="token" id="token" class="form-control @error('token') is-invalid @enderror"
                            value="{{ old('token') }}" required autofocus>
                        @error('token')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Cek Token</button>
                </form>

            </div>
        </div>
    </div> <!-- End of Card Utama -->
</div> <!-- End of Container -->

@stop

@section('css')
    <style>
        .shadow-lg {
            border-radius: 10px;
            background-color: #fff;
        }
        .shadow-sm {
            border-radius: 8px;
        }
    </style>
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
