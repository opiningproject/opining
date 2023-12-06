<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'password',
        'user_role',
        'social_id',
        'dob',
        'phone_no',
        'gender',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $appends = ['full_name'];
    public function order(){
        return $this->hasMany(Order::class, 'user_id', 'id');
    }

    public function address(){
        return $this->hasMany(Address::class, 'user_id', 'id');
    }

    public function restaurantDetails(){
        return $this->hasOne(RestaurantDetail::class,'user_id','id');
    }

    public function getFullNameAttribute(){
        return $this->first_name . ' ' . $this->last_name;
    }
}
