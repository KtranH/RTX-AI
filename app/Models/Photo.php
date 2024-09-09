<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'album_id',
        'category_id',
        'title',
        'description',
        'url',
        'is_feature',
    ];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function category()
    {
        return $this->belongsToMany(Category::class, 'category_photo');
    }
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    public function reviews()
    {
        return $this->hasMany(PostReview::class);
    }
}
