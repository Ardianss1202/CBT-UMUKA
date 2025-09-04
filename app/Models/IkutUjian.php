<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IkutUjian extends Model
{
     use HasFactory;
    protected $table = 'tr_ikut_ujian';
    protected $fillable = ['id_tes','status','id_user'];



    public function guru_tes()
    {
        return $this->belongsTo(GuruTes::class, 'id_tes','id');
    } 

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_user','id');
    }
}
