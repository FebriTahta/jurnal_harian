<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Joblist extends Model
{
    use HasFactory;
    protected $fillable = [
        'jenis_id','anggota_id','status','deskripsi','start','end'
        // ,'tanggal'
    ];
}
