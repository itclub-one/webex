<?php

namespace App\Models\admin;

use App\Models\admin\Eskul;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dokumentasi extends Model
{
    use HasFactory;

    protected $table = 'dokumentasi';

    protected $guarded = ['id'];

    public function eskul(){
        return $this->belongsTo(Eskul::class, 'eskul_id');
    }
}
