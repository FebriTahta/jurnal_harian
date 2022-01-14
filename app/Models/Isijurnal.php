<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Isijurnal extends Model
{
    use HasFactory;
    protected $fillable = [
        'title','start','end',
    ];

    public function joblist()
    {
        return $this->hasMany(Joblist::class);
    }
}
