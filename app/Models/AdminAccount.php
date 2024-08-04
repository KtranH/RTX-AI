<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminAccount extends Model
{
    use HasFactory;
    protected $fillable = [
        'username',
        'email',
        'password',
        'role_id',
        'avatar_url',
    ];

    protected $hidden = [
        'password',
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
