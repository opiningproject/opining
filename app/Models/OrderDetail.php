<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use function Symfony\Component\Translation\t;

class OrderDetail extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = ['order_id','dish_id','dish_option_id','price','qty','total_price','notes','user_id','is_cart'];
    protected $dates = ['created_at', 'updated_at'];
    protected $appends = ['paid_ingredient_total','dish_price'];
    public $timestamps = true;

    public function order(){
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function dish(){
        return $this->belongsTo(Dish::class, 'dish_id', 'id')->withTrashed();
    }

    public function dishWithoutTrash(){
        return $this->belongsTo(Dish::class, 'dish_id', 'id');
    }

    public function dishOption(){
        return $this->belongsTo(DishOption::class, 'dish_option_id', 'id')->withTrashed();
    }

    public function orderDishDetails(){
        return $this->hasMany(OrderDishDetail::class, 'order_detail_id', 'id')->withTrashed();
    }

    public function orderDishFreeIngredients(){
        return $this->hasMany(OrderDishDetail::class, 'order_detail_id', 'id')->where('is_free','1')->withTrashed();
    }

    public function orderDishPaidIngredients(){
        return $this->hasMany(OrderDishDetail::class, 'order_detail_id', 'id')->where('is_free','0')->withTrashed();
    }

    public function orderDishIngredients(){
        return $this->hasMany(OrderDishDetail::class, 'order_detail_id', 'id')->withTrashed();
    }

    public function orderDishOptionDetails(){
        return $this->hasMany(OrderDishOptionDetails::class, 'order_detail_id', 'id');
    }

    public function getPaidIngredientSumAttribute()
    {
        return $this->orderDishPaidIngredients()->select(DB::raw('sum(quantity * price) as total'))->get()->sum('total');
    }

    public function getPaidIngredientTotalAttribute()
    {
        return $this->qty * $this->orderDishPaidIngredients()->select(DB::raw('sum(quantity * price) as total'))->get()->sum('total');
    }

    public function getDishPriceAttribute(){
        if($this->dish != null){
            return $this->qty * $this->dish->price;
        }
    }
}
