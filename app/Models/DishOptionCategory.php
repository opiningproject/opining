<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DishOptionCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dish_options_categories';

    protected $fillable = ['name_en','name_nl','title_en', 'title_nl', 'sort_order'];

    protected $appends = ['name', 'title'];


    public function dishCategoryOption(){
        return $this->hasMany(DishCategoryOption::class, 'cat_id', 'id')->orderBy('sort_order');
    }
    public function getNameAttribute(){
        return $this->attributes['name_' . app()->getlocale()];
    }
    public function getTitleAttribute(){
        return $this->attributes['title_' . app()->getlocale()];
    }

    public function dishCategoryOptionWithoutTrash(){
        return $this->belongsTo(DishCategoryOption::class, 'dish_category_options_id', 'id');
    }
}
