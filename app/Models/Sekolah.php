<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    protected $table = "data_sekolah";
    protected $primaryKey = 'id_sekolah';
    protected $fillable = [
            'id_sekolah',
            'nama_sekolah',
            'nama_kepsek',
            'logo',
    ];

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'id_sekolah', 'id_sekolah');
    }

    public function mapel()
    {
        return $this->hasMany(DataPelajaran::class, 'id_sekolah', 'id_sekolah');
    }

    public function pelajaranKelas()
    {
        return $this->hasMany(PelajaranKelas::class, 'id_sekolah', 'id_sekolah');
    }

    public function mapelList()
    {
        return $this->hasMany(PelajaranKelasList::class, 'id_sekolah', 'id_sekolah');
    }


}
