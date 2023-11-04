<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = ['points','price','percentage_off','promo_code','expiry_date','description'];
    protected $dates = ['created_at', 'updated_at'];
    public $timestamps = true;
}
