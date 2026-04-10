<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
    ];
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
        
    }

    protected static function booted()
    {
        static::created(function ($user) {
            // 1. Calculate the formatted ID using the auto-increment ID
            $formattedId = 'U' . str_pad($user->id, 4, '0', STR_PAD_LEFT);

            // 2. Save it back to the database quietly 
            // (using saveQuietly to avoid triggering 'updated' events)
            $user->employee_id = $formattedId;
            $user->saveQuietly();
        });
    }

    public function attendances() : HasMany
    {
        return $this->hasMany(Attendance::class);
    }
}
