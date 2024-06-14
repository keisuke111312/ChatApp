@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h1>Chat Room: {{ $chatRoom->name }}</h1>

            <!-- Display chat room messages or other necessary data -->
            <div id="messages" class="messages">
                @if ($chatRoom->messages)
                    <!-- Loop through messages and display them -->
                    @foreach ($chatRoom->messages as $message)
                        <div class="message">
                            <strong>{{ $message->user->name }}:</strong>
                            <p>{{ $message->content }}</p>
                        </div>
                    @endforeach
                @else
                    <p>Start Conversation.</p>
                @endif
            </div>

            <!-- Add form for sending new messages -->

            <form action="{{ route('chat.sendMessage') }}" method="POST">
                @csrf
                <input type="hidden" name="chat_room_id" value="{{ $chatRoom->id }}">
                <div class="form-group">

                    <textarea name="content" id="message" class="form-control" rows="2" placeholder="Type your message"></textarea>
                </div>

                <button onclick="sendMessage()" type="submit" class="btn btn-primary" style="position:absolute; margin-left:92%; bottom:8%;">Send</button>
            </form>
        </div>
    </div>
</div>


    
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
    Pusher.logToConsole = true;

var pusher = new Pusher('2481ed54dca0691218cb', {
    cluster: 'ap1'
});

var channel = pusher.subscribe('chat');
channel.bind('message', function(data) {
    var messagesElement = document.getElementById('messages');
    messagesElement.innerHTML += '<div class="message"><p>' + data.message + '</p></div>'; 
    messagesElement.scrollTop = messagesElement.scrollHeight;
});
    function sendMessage() {
        var message = document.getElementById('message').value;

        if (message) {
            fetch('/chat/send-message', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ message: message })
            })
            .then(function(response) {
                if (response.ok) {
                    document.getElementById('message').value = '';
                }
            })
            .catch(function(error) {
                console.error('Error:', error);
            });
        }
    }
</script>

@endsection
