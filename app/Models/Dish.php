<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use function Symfony\Component\Translation\t;
use Auth;

class Dish extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = ['category_id', 'name_en', 'name_nl', 'image', 'price', 'percentage_off', 'qty', 'out_of_stock', 'desc_en', 'desc_nl'];
    protected $dates = ['created_at', 'updated_at'];
    public $timestamps = true;

    protected $appends = [
        'name',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function order()
    {
        return $this->hasMany(OrderDetail::class, 'dish_id', 'id');
    }

    public function favorite()
    {
        try
        {
            $user = Auth::user();

            if(!empty($user))
            {
                 return $this->hasOne(DishFavorites::class,'dish_id','id')->select(['*'])->where('user_id',$user->id);
            }
            else
            {
                return $this->hasOne(DishFavorites::class,'dish_id','id')->select(['*'])->where('user_id',0);
            }

            return $this->hasOne(DishFavorites::class,'dish_id','id')->select(['*'])->where('user_id',$user->id);
        }
        catch(JWTException $e)
        {
            return $this->hasOne(DishFavorites::class,'dish_id','id')->select(['*'])->where('user_id',0);
        }

    }

    public function option()
    {
        return $this->hasMany(DishOption::class, 'dish_id', 'id');
    }

    public function freeIngredients()
    {
        return $this->hasMany(DishIngredient::class, 'dish_id', 'id')->where('is_free', 1);
    }

    public function paidIngredients()
    {
        return $this->hasMany(DishIngredient::class, 'dish_id', 'id')->where('is_free', '0');
    }

    protected function getImageAttribute($value)
    {
        if (!empty($value)) {
            return asset('');
        }
        return asset('images/blank-img.svg');
    }

    public function getNameAttribute()
    {
        return $this->attributes['name_' . app()->getlocale()];
    }
}
