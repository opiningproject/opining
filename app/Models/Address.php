<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = ['user_id','company_name','house_no','street_name','city','zipcode','latitude','longitude'];
    protected $dates = ['created_at', 'updated_at'];
    public $timestamps = true;

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
