<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilUjian extends Model
{
    use HasFactory;

    protected $table = 'tr_guru_tes';
    protected $fillable = ['jumlah_soal','waktu','jenis','detil_jenis','tgl_mulai','terlambat','token'];

    public function guru()
    {
        return $this->belongsTo(GuruTes::class, 'id_guru');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'id_mapel');
    } 
}
