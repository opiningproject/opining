<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;
//use Tymon\JWTAuth\Contracts\JWTSubject;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'stripe_cust_id',
        'name',
        'stripe_cust_id',
        'collected_points',
        'first_name',
        'last_name',
        'email',
        'password',
        'user_role',
        'social_id',
        'dob',
        'phone_no',
        'gender',
        'image',
        'collected_points',
        'email_verified_at',
        'is_online',
        'enable_email_notification'
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
        return $this->hasMany(Order::class, 'user_id', 'id')->where('is_cart','0');
    }

    public function cart(){
        return $this->hasOne(Order::class, 'user_id', 'id')->where('is_cart', '1');
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

    protected function getImageAttribute($value)
    {
        if(!empty($value)){
            $s3 = Storage::disk('s3');
            return $s3->url('/user/thumb/'.$value);
        }
        return asset('images/user-profile-img.svg');
    }

    public function coupons(){
        return $this->hasMany(CouponTransaction::class, 'user_id', 'id');
    }

     /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function sentMessages(){
        return $this->hasMany(Chat::class,'sender_id','id');
    }

    public function receivedMessages(){
        return $this->hasMany(Chat::class,'receiver_id','id');
    }
}
