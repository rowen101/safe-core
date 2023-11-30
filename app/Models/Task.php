<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Enums\TaskType;
class Task extends Model
{
    use HasFactory;
    protected $table = 'tbl_dailytask';
    protected $fillable = [
        'id',
        'user_id',
        'site',
        'project',
        'plandate',
        'planenddate',
        'startdate',
        'enddate',
        'tasktype',
        'taskname',
        'status',
        'attachment',
        'PWS',
        'remarks',
        'immediate_hid',
        'status_task',

    ];


    protected $casts = [
        'created_at' => 'datetime',
        'planedate' => 'datetime',
        'planenddate' => 'datetime',
        'tasktype' => TaskType::class,
    ];

    public function formattedCreatedAt(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->created_at->format('Y-m-d h:i A'),
        );
    }
    protected $appends = [
        'formatted_created_at',
    ];

    public function formattedStartTime(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->plandate->format('Y-m-d h:i A'),
        );
    }

    public function formattedEndTime(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->planenddate->format('Y-m-d h:i A'),
        );
    }


    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format(setting('date_format'));
    }
}
