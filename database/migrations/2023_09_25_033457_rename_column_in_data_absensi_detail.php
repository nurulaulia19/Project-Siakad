<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnInDataAbsensiDetail extends Migration
{
    public function up()
    {
        Schema::table('data_absensi_detail', function (Blueprint $table) {
            $table->dropColumn('nis_siswa'); // Menghapus kolom baru
            $table->string('nis'); // Menambahkan kolom lama kembali
        });
    }

    // public function down()
    // {
    //     Schema::table('data_absensi_detail', function (Blueprint $table) {
    //         $table->dropColumn('nis_siswa'); // Menghapus kolom baru
    //         $table->string('nis'); // Menambahkan kolom lama kembali
    //     });
    // }
}

