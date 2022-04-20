<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Mahasiswa;
use App\Models\Matakuliah_Mahasiswa;

class Matakuliah extends Model
{
    use HasFactory;
    protected $table = 'matakuliah';

    public function mahasiswa()
    {
        return $this->belongsToMany(Mahasiswa::class, 'mahasiswa_matakuliah', 
        'matakuliah_id', 'mahasiswa_nim')->withPivot('nilai');
    }
}
