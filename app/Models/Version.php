<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    protected $primaryKey = 'id';
	protected $fillable = ['device_type','force_update','version_name'];
	protected $dates = ['created_at', 'updated_at'];
}
