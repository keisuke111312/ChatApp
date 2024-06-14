<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'user_id', 'chat_room_id'];


    public function user(){

        return $this->belongsTo(User::class);
    }
    

    public function chatRoom(){

        return $this->belongsTo(ChatRoom::class);

    }
}
