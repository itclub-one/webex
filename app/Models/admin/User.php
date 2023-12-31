<?php

namespace App\Models\admin;

use App\Models\admin\Eskul;
use App\Models\admin\UserGroup;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'user_group_id',
        'kode',
        'eskul_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // relasi
    public function user_group(){
        return $this->belongsTo(UserGroup::class, 'user_group_id');
    }
    
    public function profile(){
        return $this->hasOne(Profile::class, 'user_kode', 'kode');
    }
    
    public function eskul(){
        return $this->belongsTo(Eskul::class, 'eskul_id');
    }
}
