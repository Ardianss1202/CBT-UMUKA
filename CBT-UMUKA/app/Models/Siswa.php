<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'm_siswa'; // Sesuaikan dengan nama tabel di database
    protected $primaryKey = 'id'; // Pastikan ini sesuai dengan primary key tabel
    public $timestamps = false; // Nonaktifkan jika tabel tidak memiliki created_at & updated_at

    protected $fillable = ['nama', 'nim', 'jurusan']; // Sesuaikan dengan kolom di tabel

   
}
