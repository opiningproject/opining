<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CMS extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = ['content','lang','type'];
    protected $dates = ['created_at', 'updated_at'];
    public $timestamps = true;
}
