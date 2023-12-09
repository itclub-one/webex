<?php

namespace App\Models\admin;

use App\Models\admin\Eskul;
use App\Models\admin\Kelas;
use App\Models\admin\Jurusan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Anggota extends Model
{
    use HasFactory;

    protected $table = 'anggota';

    protected $guarded = ['id'];

    public function eskul(){
        return $this->belongsTo(Eskul::class, 'eskul_id');
    }
    
    public function kelas(){
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
    
    public function jurusan(){
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }
}
