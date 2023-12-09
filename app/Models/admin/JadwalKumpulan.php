<?php

namespace App\Models\admin;

use App\Models\admin\Eskul;
use App\Models\admin\Jadwal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JadwalKumpulan extends Model
{
    use HasFactory;

    protected $table = 'jadwal_kumpulan';

    protected $guarded = ['id'];

    public function eskul()
    {
        return $this->belongsToMany(Eskul::class);
    }
    
    public function jadwal(){
        return $this->belongsTo(Jadwal::class, 'jadwal_id', 'id');
    }
}
