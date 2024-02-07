<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use function Symfony\Component\Translation\t;

class OrderUserDetail extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = ['order_id','order_name','order_contact_number','company_name','house_no','street_name','city','zipcode','latitude','longitude'];
    protected $dates = ['created_at', 'updated_at'];
    public $timestamps = true;

    public function order(){
        return $this->belongsTo(Order::class,'order_id', 'id');
    }
}
