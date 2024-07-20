<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPelanggaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'sanksi_id',
        'total_bobot',
    ];
}
