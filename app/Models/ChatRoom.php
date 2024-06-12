<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    use HasFactory;

    public function user(){

        return $this>belongsToMany(User::class);
        
    }

    public function message(){

        return $this->hasMany(Message::class);
        
    }
}
