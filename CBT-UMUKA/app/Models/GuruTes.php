<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuruTes extends Model
{
    use HasFactory;
    protected $table = 'tr_guru_tes';
    protected $fillable = [
        'nama_ujian',
        'jumlah_soal',
        'waktu',
        'token'
    ];

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'id_mapel');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }

    public function ikut_ujian()
    {
        return $this->hasMany(IkutUjian::class, 'id_tes', 'id');
    }

}
