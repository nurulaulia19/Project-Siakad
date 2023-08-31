<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPelajaran extends Model
{
    use HasFactory;
    protected $table = "data_pelajaran";
    protected $primaryKey = 'id_pelajaran';
    protected $fillable = [
            'id_pelajaran',
            'kode_pelajaran',
            'user_id',
            'id_sekolah',
            'nama_pelajaran',
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah', 'id_sekolah');
    }

    public function user()
    {
        return $this->belongsTo(DataUser::class, 'user_id', 'user_id');
    }

    public function mapelList()
    {
        return $this->hasMany(PelajaranKelasList::class, 'id_sekolah', 'id_sekolah');
    }
}
