<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ChatRoom;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $currentlyLogUser = Auth::user();
        $chatRooms = $currentlyLogUser->chatRoom()->with('users')->get();
        $users = User::all();
        return view('chat.create', compact('chatRooms', 'currentlyLogUser', 'users'));
    }
    
    
    
}
