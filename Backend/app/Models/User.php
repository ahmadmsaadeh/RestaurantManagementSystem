<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $primaryKey = 'user_id';
    protected $fillable = [
        'username',
        'email',
        'firstname',
        'lastname',
        'phonenumber',
        'auth_token',
        'token_expiry',
        'role_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'auth_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'token_expiry' => 'datetime',
            'date_joined' => 'datetime',
        ];
    }
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id','role_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'UserID','user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id','user_id');
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'customer_id','user_id');
    }
}
