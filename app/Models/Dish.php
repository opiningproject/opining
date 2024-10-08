<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
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
        'cart',
        'description'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function order()
    {
        return $this->hasOne(OrderDetail::class, 'dish_id', 'id');
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

//    public function option()
//    {
//        return $this->hasMany(DishOption::class, 'dish_id', 'id')->withTrashed();
//    }
    public function dishOption()
    {
        return $this->hasMany(DishOption::class, 'dish_id', 'id')->withTrashed();
    }

    public function optionWithoutTrashed()
    {
        return $this->hasMany(DishOption::class, 'dish_id', 'id')->withTrashed();
    }

    public function freeIngredients()
    {
        return $this->hasMany(DishIngredient::class, 'dish_id', 'id')->where('is_free', 1)->withTrashed();
    }

    public function paidIngredients()
    {
        return $this->hasMany(DishIngredient::class, 'dish_id', 'id')->where('is_free', '0')->withTrashed();
    }

    public function freeWithoutTrashIngredients()
    {
        return $this->hasMany(DishIngredient::class, 'dish_id', 'id')->where('is_free', 1);
    }

    public function paidWithoutTrashIngredients()
    {
        return $this->hasMany(DishIngredient::class, 'dish_id', 'id')->where('is_free', '0');
    }

    public function ingredients(){
        return $this->hasMany(DishIngredient::class, 'dish_id', 'id')->withTrashed();
    }

    public function ingredientsWithoutTrash(){
        return $this->hasMany(DishIngredient::class, 'dish_id', 'id');
    }

    protected function getImageAttribute($value)
    {
        if(!empty($value)){
            $s3 = Storage::disk('s3');
            return $s3->url('/dish/thumb/'.$value);
        }
        return asset('images/blank-img.svg');
    }

    public function getNameAttribute()
    {
        return $this->attributes['name_' . app()->getlocale()];
    }

    public function getCartAttribute()
    {
        try
        {
            $user = Auth::user();
            $user_id = ($user) ? $user->id : 0;

            return $this->hasOne(OrderDetail::class,'dish_id','id')->select(['*'])->where('is_cart','1')->where('user_id',$user_id)->count();
        }
        catch(JWTException $e)
        {
            return 0;
        }

    }

    public function getDescriptionAttribute()
    {
        return $this->attributes['desc_' . app()->getlocale()];
    }

    public function getPriceAttribute($value){
        return $value;
    }

    public function cartOrderDetails(){
        return $this->hasMany(OrderDetail::class, 'dish_id', 'id')->where('is_cart', '1');
    }

    public function adminFavourite(){
        return $this->hasMany(DishFavorites::class, 'dish_id', 'id');
    }
}
