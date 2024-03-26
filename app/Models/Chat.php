<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['sender_id','receiver_id ','message','attachment'];

    public function sender(){
        return $this->belongsTo(User::class,'sender_id');
    }
    public function receiver(){
        return $this->belongsTo(User::class,'receiver_id');
    }


    public function scopegetChats($query,$search = '')
    {

        $chats = $this->selectRaw('sender_id, receiver_id, COUNT(*) as total_chats,created_at')
        ->with('sender')
        ->groupBy('sender_id', 'receiver_id','created_at')
        ->having('total_chats', '>', 0);

        if(!empty($search))
		{
            $chats->whereHas('sender', function($query) use ($search) {
                $query->where('first_name', 'like', "%$search%");
            });
		}


        return $chats;
    }
}
