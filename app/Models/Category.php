<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
    ];
    public $timestamps = false;
    public function photos()
    {
        return $this->belongsToMany(Photo::class, 'category_photo');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'preferences', 'category_id', 'user_id');
    }
}
