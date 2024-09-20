<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackOrder extends Model
{
    use HasFactory;

    protected $fillable = ['order_id','order_status'];

    public function getCreatedAtAttribute($value)
    {
        return date('d M H:i',strtotime($value));
    }

}
