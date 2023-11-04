<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use function Symfony\Component\Translation\t;

class OrderDetail extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = ['order_id','dish_id','price','qty','total_price','notes'];
    protected $dates = ['created_at', 'updated_at'];
    public $timestamps = true;

    public function order(){
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function dish(){
        return $this->belongsTo(Dish::class, 'dish_id', 'id');
    }
}
