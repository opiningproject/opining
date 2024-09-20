<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Banner extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'banners';

    protected $fillable = ['content_en','content_nl','image','status', 'sort_order'];

    protected $appends = ['content'];

    public function getContentAttribute(){
        return $this->attributes['content_' . app()->getlocale()];
    }

    public function getImageAttribute($value){
        if(!empty($value)){
            $s3 = Storage::disk('s3');
            return $s3->url('/banners/'.$value);
        }
        return asset('images/blank-img.svg');
    }
}
