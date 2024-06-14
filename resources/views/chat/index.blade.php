@extends('layouts.app')
@section('content')
    
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Chat Application</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    .chat-container {
        max-width: 600px;
        margin: 20px auto;
        background-color: white;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    .message-box {
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px;
        margin-bottom: 10px;
    }

    .input-container {
        display: flex;
        margin-top: 10px;
    }

    .input-container input {
        flex: 1;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
    }

    .input-container button {
        margin-left: 10px;
        padding: 10px 20px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
</style>
</head>
<body>
<div class="chat-container">
    <div id="messages" class="message-box"></div>
    <div class="input-container">
        <input type="text" id="username" placeholder="Username">
        <input type="text" id="message" placeholder="Message">
        <button onclick="sendMessage()">Send</button>
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
    // Append the new message to the chat room messages
    var messagesElement = document.getElementById('messages');
    messagesElement.innerHTML += '<div class="message"><strong>' + data.user + ':</strong><p>' + data.message + '</p></div>';
    
    // Scroll to the bottom of the messages container to show the latest message
    messagesElement.scrollTop = messagesElement.scrollHeight;
});

    function sendMessage() {
        var username = document.getElementById('username').value;
        var message = document.getElementById('message').value;

        if (username && message) {
            fetch('/send-message', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ username: username, message: message })
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