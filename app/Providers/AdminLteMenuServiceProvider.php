<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AdminLteMenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $level = session('level');

            $menu = [
                ['header' => 'DAFTAR MENU'],
            ];

            if ($level === 'admin') {
                $menu[] = [
                    'text' => 'Dashboard',
                    'url' => 'dashboard',
                    'icon' => 'fas fa-home nav-icon',
                ];
                $menu[] = [
                    'text' => 'Data camaba',
                    'url' => 'data-camaba',
                    'icon' => 'fas fa-fw fa-user nav-icon',
                ];
                $menu[] = [
                    'text' => 'Data Soal',
                    'url' => 'data-soal',
                    'icon' => 'fas fa-book nav-icon',
                ];
                $menu[] = [
                    'text' => 'Data Mapel',
                    'url' => 'data-mapel',
                    'icon' => 'fas fa-book nav-icon',
                ];
                $menu[] = [
                    'text' => 'Ujian',
                    'url' => 'data-ujian',
                    'icon' => 'fas fa-book nav-icon',
                ];
                $menu[] = [
                    'text' => 'Hasil Ujian',
                    'url' => 'hasil-ujian',
                    'icon' => 'fas fa-chart-line nav-icon',
                ]; 
            } else {
                $menu[] = [
                    'text' => 'Dashboard',
                    'url' => 'dashboard',
                    'icon' => 'fas fa-home nav-icon',
                ];
                $menu[] = [
                    'text' => 'Ujian',
                    'url' => 'ujian',
                    'icon' => 'fas fa-book nav-icon',
                ];
           
            }

            // Set ke konfigurasi AdminLTE
            config(['adminlte.menu' => $menu]);
        });
    }
}
