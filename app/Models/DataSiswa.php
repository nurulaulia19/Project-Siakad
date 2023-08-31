<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSiswa extends Model
{
    use HasFactory;
    protected $table = "data_siswa";
    protected $primaryKey = 'id_siswa';
    protected $fillable = [
            'id_siswa',
            'nama_siswa',
            'nis_siswa',
            'tempat_lahir',
            'tanggal_lahir',
            'jenis_kelamin',
            'tahun_masuk',
            'password',
            'foto_siswa',
    ];

}
