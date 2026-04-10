<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminates\Database\Eloquent\SoftDeletes;
use SoftDeletes;

class Attendance extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'user_id',
        'attendance_date',
        'check_in_time',
        'check_in_latitude',
        'check_in_longitude',
        'checkin_photo',
        'check_out_time',
        'check_out_latitude',
        'check_out_longitude',
        'checkout_photo',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'attendance_date' => 'date',
            'check_in_time' => 'datetime',
            'check_out_time' => 'datetime',
            'check_in_latitude' => 'decimal:8',
            'check_in_longitude' => 'decimal:8',
            'check_out_latitude' => 'decimal:8',
            'check_out_longitude' => 'decimal:8',
        ];
    }   

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
