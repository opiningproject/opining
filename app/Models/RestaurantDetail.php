<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class RestaurantDetail extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = ['user_id','restaurant_name','permit_id','phone_no','rest_address','latitude','longitude','online_order_accept','restaurant_logo','permit_doc','service_charge','footer_logo', 'order_notif_sound','delivery_time','take_away_time'];
    protected $dates = ['created_at', 'updated_at'];
    public $timestamps = true;

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function getRestaurantLogoAttribute($value){
        if(!empty($value)){
            $s3 = Storage::disk('s3');
            return $s3->url('/restaurant/'.$value);
        }

        return asset('images/blank-img.svg');
    }

    public function getPermitDocAttribute($value){
        if(!empty($value)){
            $s3 = Storage::disk('s3');
            return $s3->url('/restaurant/'.$value);
        }

        return asset('images/blank-img.svg');
    }

    public function getFooterLogoAttribute($value){
        if(!empty($value)){
            $s3 = Storage::disk('s3');
            return $s3->url('/restaurant/'.$value);
        }

        return asset('images/blank-img.svg');
    }
}
