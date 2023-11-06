<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RestaurantDetail extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = ['user_id','restaurant_name','permit_id','phone_no','rest_address','latitude','longitude','online_order_accept','restaurant_logo','permit_doc','service_charge'];
    protected $dates = ['created_at', 'updated_at'];
    public $timestamps = true;

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
