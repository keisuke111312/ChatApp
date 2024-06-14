@extends('layouts.app')
@section('content')
    <form action="{{ route('chat.store') }}" method="POST">
        @csrf

        <label for="user_id">Select User:</label>
        <select name="user_id" id="user_id">
            @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>

        <button type="submit">Start Chat</button>
    </form>


    <div class="chat-room-details">
        <h2>Chat Room Details</h2>



        @foreach ($chatRooms as $chatRoom)
            <div class="chat-room-details">
                @foreach ($chatRoom->users as $chatUser)
                    @if ($chatUser->id !== $currentlyLogUser->id)
                        <p><a href="{{ route('chat.show', $chatRoom->id) }}">{{ $chatUser->name }}</a></p>
                    @break
                @endif
            @endforeach
        </div>
    @endforeach
</div>
@endsection
