<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $table = 'notifications';
    protected $fillable = [
        'id', 'user_id', 'type', 'data', 'is_read', 'created_at', 'updated_at'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
