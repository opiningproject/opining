<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use function Symfony\Component\Translation\t;

class Ingredient extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = ['category_id','name_en','name_nl','image','status'];
    protected $dates = ['created_at', 'updated_at'];
    public $timestamps = true;

    public function category(){
        return $this->belongsTo(IngredientCategory::class, 'category_id', 'id');
    }

    public function dishIngredient(){
        return $this->hasMany(DishIngredient::class, 'ingredient_id', 'id');
    }
}
