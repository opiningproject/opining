<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Zipcode extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = ['zipcode','min_order_price','delivery_charge','status'];
    protected $dates = ['created_at', 'updated_at'];
    public $timestamps = true;
}
