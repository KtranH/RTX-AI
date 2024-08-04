<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{
    use HasFactory;
    protected $fillable = [
        'role_name',
        'description',
    ];

    public function adminAccounts()
    {
        return $this->hasMany(AdminAccount::class);
    }
}
