<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function joblist()
    {
        return $this->hasMany(Joblist::class);
    }

    public function bidang()
    {
        return $this->belongsTo(Bidang::class);
    }
}
