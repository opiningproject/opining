<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DishCategoryOption extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dish_categories_options';

    protected $fillable = ['cat_id','dish_id','name_en','name_nl','price','status','sort_order'];
    protected $appends = ['name'];
    public function getNameAttribute(){
        return $this->attributes['name_' . app()->getlocale()];
    }


//    public function dishOption(){
//        return $this->hasMany(DishOption::class,'dish_category_options_id','id');
//    }
    public function dishOptions()
    {
        return $this->hasMany(DishOption::class, 'dish_category_options_id');
    }

    public function DishOptionCategory(){
        return $this->belongsTo(DishOptionCategory::class, 'cat_id', 'id');
    }
}
