<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    //
use HasFactory;
    protected $fillable = [
        'name',
        'address',
        'latitude',
        'longitude',
        'radius',
        'work_start_time',
        'work_end_time',
    ];

    protected function casts(): array
    {
        return [
            'work_start_time' => 'datetime:H:i',
            'work_end_time' => 'datetime:H:i',
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
        ];
    }

    public function getCompany(): ? self
    {
        return self::first();
    }

}
