<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DishIngredient extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = ['ingredient_id','dish_id','price','is_free'];
    protected $dates = ['created_at', 'updated_at'];
    public $timestamps = true;

    public function ingredient(){
        return $this->belongsTo(Ingredient::class, 'ingredient_id', 'id');
    }

    public function dish(){
        return $this->belongsTo(Dish::class, 'dish_id', 'id');
    }

    public function scopeFreeIngredient($query){
        return $query->whereIsFree(1)->get();
    }

    public function scopePaidIngredient($query){
        return $query->whereIsFree(0)->get();
    }
}
