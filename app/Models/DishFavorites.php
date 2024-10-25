<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class DishFavorites extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id','dish_id'];
    public $timestamps = false;

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function dish(){
        return $this->belongsTo(Dish::class, 'dish_id' ,'id');
    }
}
