<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class AdminAccount extends Model implements AuthenticatableContract
{
    use HasFactory, Authenticatable;
    protected $fillable = [
        'username',
        'email',
        'password',
        'role_id',
        'avatar_url',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function adminRole()
    {
        return $this->belongsTo(AdminRole::class, 'role_id');
    }
    public function reviews()
    {
        return $this->hasMany(PostReview::class, 'admin_id');
    }
}
