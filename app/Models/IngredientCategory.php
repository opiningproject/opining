<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IngredientCategory extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = ['name_en','name_nl', 'sort_order'];
    protected $dates = ['created_at', 'updated_at'];
    protected $appends = ['name'];
    public $timestamps = true;

    public function ingredients(){
        return $this->hasMany(Ingredient::class, 'category_id', 'id');
    }

    public function getNameAttribute(){
        return $this->attributes['name_' . app()->getlocale()];
    }
}
