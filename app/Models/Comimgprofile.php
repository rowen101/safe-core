<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comimgprofile extends Model
{
    use HasFactory;
    protected $table = "comimgprofiles";
    protected $fillable = [
        'id',
        'company_img',
        'is_active',
    ];
}
