<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sanksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'sanksi',
        'bobot_dari',
        'bobot_sampai',
        'keterangan'
    ];
}
