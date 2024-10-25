<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Coupon extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = ['points','price','percentage_off','promo_code','start_expiry_date','end_expiry_date','description'];
    protected $dates = ['created_at', 'updated_at'];
    public $timestamps = true;

    public function scopeWithActive($query)
    {
        return $query->where('status', '1');
    }

    public function couponTransaction()
    {
        $user = Auth::user();

        return $this->hasOne(CouponTransaction::class,'coupon_id','id')->where('user_id',$user->id);
    }

    public function transactions()
    {
        return $this->hasMany(CouponTransaction::class);
    }

    public function scopeExpired($query)
    {
        return $query->where('end_expiry_date', '<', now());
    }

    public function scopeUnexpired($query)
    {
        return $query->where('end_expiry_date', '>=', now());
    }
}
