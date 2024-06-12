<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\Message;
use App\Models\ChatMessage;


class ChatController extends Controller
{


    public function showPusherTest()
    {
        return view('chat.index');
    }

   public function message(Request $request){

        $username = $request->input('username');
        $message = $request->input('message');


        event(new Message($username, $message));


        return response()->json([], 200);
   }
}
