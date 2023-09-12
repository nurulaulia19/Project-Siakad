<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuruPelajaran extends Model
{
    use HasFactory;
    protected $table = "data_guru_pelajaran";
    protected $primaryKey = 'id_gp';
    protected $fillable = [
            'id_gp',
            'id_pelajaran',
            'id_kelas',
            'id_sekolah',
            'tahun_ajaran',
            'user_id',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah', 'id_sekolah');
    }

    public function mapel()
    {
        return $this->belongsTo(DataPelajaran::class, 'id_pelajaran', 'id_pelajaran');
    }

    public function user()
    {
        return $this->belongsTo(DataUser::class, 'user_id', 'user_id');
    }

    public function guruMapelJadwal()
    {
        return $this->hasMany(GuruPelajaranJadwal::class, 'id_gp', 'id_gp');
    }

    // public function mapelList()
    // {
    //     return $this->hasMany(PelajaranKelasList::class, 'id_pk', 'id_pk')->with('sekolah', 'mapel');
    // }
}