<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\ChatMessage;
use App\Models\User;
use App\Models\ChatRoom;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Events\MessageEvent;




class ChatController extends Controller
{

    public function showPusherTest()
    {
        return view('chat.index');
    }

    // public function message(Request $request)
    // {

    //     $username = $request->input('username');
    //     $message = $request->input('message');


    //     event(new MessageEvent($username, $message));


    //     return response()->json([], 200);
    // }

    public function create()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('chat.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);
    
        $existingChatRoom = Auth::user()->chatRoom()->whereHas('users', function ($query) use ($validatedData) {
            $query->where('users.id', $validatedData['user_id']);
        })->first();
    
        if ($existingChatRoom) {
            // If an existing chat room is found, redirect to it
            return redirect()->route('chat.show', $existingChatRoom);
        }
    
        // If no existing chat room is found, create a new one
        $chatRoom = ChatRoom::create([
            'user_id' => Auth::id(),
        ]);
    
        $chatRoom->users()->attach([$chatRoom->user_id, $validatedData['user_id']]);
    
        return redirect()->route('chat.show', $chatRoom);
    }
    

    public function show(ChatRoom $chatRoom)
    {
        return view('chat.show', compact('chatRoom'));
    }

    public function sendMessage(Request $request)
    {
        $message = new Message();
        $message->content = $request->content;
        $message->user_id = $request->user()->id;
        $message->chat_room_id = $request->chat_room_id;
        $message->save();
    
        event(new MessageEvent($message->content));
    
        return redirect('/chat/room/' . $request->input('chat_room_id'));
    }



}
