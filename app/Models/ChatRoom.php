<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    use HasFactory;

    protected $fillable=['user_id','chat_room_id'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'chat_room_user', 'chat_room_id', 'user_id')
            ->withPivot('created_at'); 
    }

    public function messages(){

        return $this->hasMany(Message::class);
        
    }
}
