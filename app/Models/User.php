<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // If you're using Laravel Sanctum

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'picture',
        'joined_with',
        'is_email_verified',
        'email_last_verfication_code',
        'email_last_verfication_code_expird_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // relations ships
    public function cart()
    {
        return $this->hasMany('App\Models\Cart', 'user_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'user_id');
    }

    public function appointments()
    {
        return $this->hasMany('App\Models\Appointment', 'user_id');
    }


}
