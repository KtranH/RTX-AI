<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostReview extends Model
{
    use HasFactory;
    protected $fillable = [
        'photo_id',
        'admin_id',
        'review_content',
        'status',
    ];

    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }

    public function admin()
    {
        return $this->belongsTo(AdminAccount::class, 'admin_id');
    }
}
