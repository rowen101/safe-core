<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tech extends Model
{
    use HasFactory;

    protected $table ="teches";
    protected $fillable = ['id', 'techno','company','branch','department','warehouse',
    'user','report','udetails','ass_conducted','recommendation','created_by','updated_by'];
}
