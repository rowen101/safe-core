<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppUser extends Model
{
    use HasFactory;

    protected $table = "app_users";

    protected $fillable = [
        'id',
        'user_id',
        'app_id',
        'is_active'
    ];
}
