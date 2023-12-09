<?php

namespace App\Models\admin;

use App\Models\admin\Eskul;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sekbid extends Model
{
    use HasFactory;

    protected $table = 'sekbid';

    protected $guarded = ['id'];

    public function eskul(){
        return $this->hasMany(Eskul::class, 'sekbid_id', 'id');
    }
}
