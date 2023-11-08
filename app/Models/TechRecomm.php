<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechRecomm extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'techrecomms';

    protected $fillable = [
        'id',
        'recommnum',
        'company',
        'branch',
        'department',
        'warehouse',
        'user',
        'problem',
        'udetails',
        'assconducted',
        'crated_by',
        'updated_by',
        'is_active',
    ];

    protected $appends = [
        'formatted_created_at',
    ];

    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format(setting('date_format'));
    }
}
