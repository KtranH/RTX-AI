<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryImageAI extends Model
{
    use HasFactory;
    protected $table = 'history_image_ai';
    protected $fillable = [
        'user_id',
        'url', 
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
