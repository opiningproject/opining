<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IngredientCategory extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = ['name_en','name_nl'];
    protected $dates = ['created_at', 'updated_at'];
    public $timestamps = true;

    public function ingredients(){
        return $this->hasMany(Ingredient::class, 'category_id', 'id');
    }
}
