<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDishDetail extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = ['order_detail_id','dish_id','price','quantity','total','dish_ingredient_id','is_free'];
    protected $dates = ['created_at', 'updated_at'];
    public $timestamps = true;

    public function orderDetail(){
        return $this->belongsTo(OrderDetail::class, 'order_detail_id');
    }

    public function dish(){
        return $this->belongsTo(Dish::class, 'dish_id');
    }

    public function dishIngredient(){
        return $this->belongsTo(DishIngredient::class, 'dish_ingredient_id', 'id');
    }

    public function scopeFreeIngredient($query){
        return $query->whereIsFree(1)->get();
    }

    public function scopePaidIngredient($query){
        return $query->whereIsFree(0)->get();
    }
}
