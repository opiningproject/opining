<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use function Symfony\Component\Translation\t;

class Ingredient extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = ['category_id','name_en','name_nl','image','status'];
    protected $dates = ['created_at', 'updated_at'];
    protected $appends = ['name'];
    public $timestamps = true;

    public function category(){
        return $this->belongsTo(IngredientCategory::class, 'category_id', 'id');
    }

    public function dishIngredient(){
        return $this->hasMany(DishIngredient::class, 'ingredient_id', 'id');
    }

    public function freeDishIngredient(){
        return $this->hasMany(DishIngredient::class, 'ingredient_id', 'id')->where('is_free','1');
    }

    public function paidDishIngredient(){
        return $this->hasMany(DishIngredient::class, 'ingredient_id', 'id')->where('is_free','0');
    }

    public function getNameAttribute(){
        return $this->attributes['name_' . app()->getlocale()];
    }

    public function getImageAttribute($value){
        if(!empty($value)){
            $s3 = Storage::disk('s3');
            return $s3->url('/ingredients/thumb/'.$value);
        }
        return asset('images/blank-img.svg');
    }
}
