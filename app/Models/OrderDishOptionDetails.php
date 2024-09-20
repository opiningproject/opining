<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDishOptionDetails extends Model
{
    use HasFactory;
    protected $fillable = ['order_detail_id', 'dish_option_id'];


    public function orderDetail(){
        return $this->hasMany(OrderDetail::class, 'id', 'order_detail_id');
    }

    public function DishCategoryOption(){
        return $this->hasMany(DishCategoryOption::class, 'id', 'dish_option_id');
    }
}
