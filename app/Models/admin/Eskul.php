<?php

namespace App\Models\admin;

use App\Models\admin\Sekbid;
use App\Models\admin\EskulDetail;
use App\Models\admin\JadwalKumpulan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Eskul extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'eskul';

    protected $guarded = ['id'];

    public function sekbid(){
        return $this->belongsTo(Sekbid::class, 'sekbid_id', 'id');
    }
    
    public function jadwal_kumpulan(){
        return $this->belongsToMany(JadwalKumpulan::class);
    }

    public function eskul_detail(){
        return $this->hasOne(EskulDetail::class, 'eskul_id', 'id');
    }
}
