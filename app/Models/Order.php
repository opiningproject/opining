<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','transaction_id','coupon_id','refund_status','refund_description','payment_type','payment_status','delivery_charge','platform_charge','total_amount','order_status','order_type','order_date','delivery_date','delivery_time','delivery_note','receive_update_emails','points','coupon_code','payment_response','is_cart','is_admin_notified','expected_delivery_time'];
    protected $dates = ['created_at', 'updated_at'];
    protected $appends=['item_total'];

    public $timestamps = true;

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function dishDetails(){
        return $this->hasMany(OrderDetail::class, 'order_id', 'id')->withTrashed();
    }

    public function orderUserDetails(){
        return $this->hasOne(OrderUserDetail::class, 'order_id' ,'id')->withTrashed();
    }

    public function coupon(){
        return $this->belongsTo(Coupon::class, 'coupon_id','id');
    }

    public function getDeliveryTimeAttribute($value)
    {
        return $value ? date('g:i A',strtotime($value)) : 'ASAP';
    }

    public function getCreatedAtAttribute($value)
    {
        return date('F d, Y, g:i A',strtotime($value));
    }

    public function getItemTotalAttribute()
    {
        return $this->total_amount - $this->platform_charge - $this->delivery_charge + $this->coupon_discount;
    }

    public function getDeliveryChargeAttribute($value){
        return $value;
    }

    public function getTotalAmountAttribute($value){
        return $value;
    }
}
