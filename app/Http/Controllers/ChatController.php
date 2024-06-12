<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\Message;
use App\Models\ChatMessage;


class ChatController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }


    // public function index()
    // {
    //     $messages = ChatMessage::with('user')->get();
    //     return response()->json($messages);
    // }

    // public function store(Request $request)
    // {
    //     $message = new ChatMessage([
    //         'user_id' => auth()->user()->id,
    //         'message' => $request->input('message'),
    //     ]);
    //     $message->save();

    //     event(new NewMessageEvent($message));

    //     return response()->json($message);
    // }

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
