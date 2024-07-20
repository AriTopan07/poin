<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailSiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'nisn',
        'nama_siswa',
        'telp_siswa',
        'jk',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'nama_wali',
        'telp_wali',
        'status',
        'alamat_wali',
    ];
}
