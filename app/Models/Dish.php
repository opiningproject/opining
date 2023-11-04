<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use function Symfony\Component\Translation\t;

class Dish extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = ['category_id','name_en','name_nl','image','price','percentage_off','qty'];
    protected $dates = ['created_at', 'updated_at'];
    public $timestamps = true;

    public function category(){
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function order(){
        return $this->hasMany(OrderDetail::class, 'dish_id', 'id');
    }
}
