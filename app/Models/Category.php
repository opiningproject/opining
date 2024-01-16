<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = ['name_en','name_nl','image'];
    protected $dates = ['created_at', 'updated_at'];
    public $timestamps = true;

    protected $appends = [
        'name',
    ];

    public function dish(){
        return $this->hasMany(Dish::class, 'category_id', 'id');
    }

    public function getNameAttribute()
    {
        return $this->attributes['name_' . app()->getlocale()];
    }

    public function getImageAttribute($value){
        if(!empty($value)){
            $s3 = Storage::disk('s3');
            return $s3->url('/category/thumb/'.$value);
        }
        return asset('images/blank-img.svg');
    }
}
