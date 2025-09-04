@extends('adminlte::page')

@section('title', 'Dashboard')


@section('content_header')
    <h1>Dashboard</h1>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

@stop

@section('content')


<div class="container">
    <!-- Card Utama -->
    <div class="card shadow-lg p-4">
        <div class="card-body">
            <p class="alert alert-primary">Selamat datang di sistem ujian online, Anda login sebagai <strong>ADMIN</strong>.</p>

            <!-- Row untuk Statistik -->
            <div class="row mt-4">
                <div class="col-md-3">
                    <div class="card shadow-lg border-0 rounded-3">
                        <div class="card-body text-center">
                            <div class="icon-box bg-info text-white rounded-2 mb-3 p-3">
                                <i class="fas fa-users fa-2x"></i>
                            </div>
                            <p class="text-muted">Data Camaba</p>
                        </div>
                    </div>
                </div>
            
                <div class="col-md-3">
                    <div class="card shadow-lg border-0 rounded-3">
                        <div class="card-body text-center">
                            <div class="icon-box bg-success text-white rounded-2 mb-3 p-3">
                                <i class="fas fa-book fa-2x"></i>
                            </div>
                            <p class="text-muted">Data Soal</p>
                        </div>
                    </div>
                </div>
            
                <div class="col-md-3">
                    <div class="card shadow-lg border-0 rounded-3">
                        <div class="card-body text-center">
                            <div class="icon-box bg-warning text-white rounded-2 mb-3 p-3">
                                <i class="fas fa-file fa-2x"></i>
                            </div>
                            <p class="text-muted">Data Mapel</p>
                        </div>
                    </div>
                </div>
            
                <div class="col-md-3">
                    <div class="card shadow-lg border-0 rounded-3">
                        <div class="card-body text-center">
                            <div class="icon-box bg-danger text-white rounded-2 mb-3 p-3">
                                <i class="fas fa-chart-line fa-2x"></i>
                            </div>
                            <p class="text-muted">Hasil Ujian</p>
                        </div>
                    </div>
                </div>
            </div>
            
                    </div>
                </div>
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
