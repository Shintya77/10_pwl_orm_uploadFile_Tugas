<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Mahasiswa as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model; //Model Eloquent
use App\Models\Kelas;
use App\Models\Matakuliah_Mahasiswa;

class Mahasiswa extends Model 
{
    protected $guarded = [];
    protected $table='mahasiswa'; // Eloquent akan membuat model mahasiswa menyimpan record ditabel mahasiswa
    public $timestamps = false;
    protected  $primaryKey = 'Nim'; // Memanggil isi DB Dengan primarykey
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Nim', 
        'Nama',
        'Foto',
        'Kelas',
        'Jurusan',
        'No_Handphone',
        'Email',
        'Alamat',
        'TanggalLahir',
    ];

    public function kelas(){
        return $this->belongsTo(Kelas::class);
    }

    public function matakuliah(){
        return $this->belongsToMany(MataKuliah::class,'mahasiswa_matakuliah','mahasiswa_id','matakuliah_id')->withPivot('nilai');
    }
};