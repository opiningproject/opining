<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','transaction_id','payment_type','payment_status','delivery_charge','platform_charge','total_amount','order_status','order_type','order_date','delivery_date','delivery_time','delivery_note','receive_update_emails','points','coupon_code','payment_response','is_cart'];
    protected $dates = ['created_at', 'updated_at'];
    public $timestamps = true;

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function dishDetails(){
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }

    public function orderUserDetails(){
        return $this->hasOne(OrderUserDetail::class, 'order_id' ,'id');
    }
}
