<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedImage extends Model
{
    use HasFactory;
    protected $table = 'saved_image';
    protected $fillable = [
        'id',
        'user_id',
        'photo_id', 
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
