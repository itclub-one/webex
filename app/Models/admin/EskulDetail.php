<?php

namespace App\Models\admin;

use App\Models\admin\Eskul;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class EskulDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'eskul_detail';

    protected $guarded = ['id'];

    public function eskul(){
        return $this->belongsTo(Eskul::class, 'eskul_id', 'id');
    }
}
