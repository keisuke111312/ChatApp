@extends('layouts.app')
@section('content')
    

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chat Application</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .message-box {
            height: 400px;
            overflow-y: scroll;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="chat-container">
            <div id="messages" class="message-box"></div>
            <div class="input-container">
                <input type="text" id="message" class="form-control" placeholder="Message">
                <button onclick="sendMessage()" class="btn btn-primary">Send</button>
            </div>
        </div>
    </div>

    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
        Pusher.logToConsole = true;

        var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
        });

        var channel = pusher.subscribe('chat');
        channel.bind('message', function(data) {
            addMessageToChat(data.username, data.message);
        });


        console.log('Event listener added');
        var messageForm = document.getElementById('messageForm');
        if (messageForm) {
            messageForm.addEventListener('submit', function(e) {
                e.preventDefault();
                console.log('Form submitted');
                var username = document.getElementById('username').value;
                var message = document.getElementById('message').value;

                if (message.trim() === '') {
                    alert('Please enter a message.');
                    return;
                }

                axios.post('/send-message', {
                        username: username,
                        message: message
                    })
                    .then(function(response) {
                        displayMessage(username, message);
                        messageForm.reset();
                    })
                    .catch(function(error) {
                        console.error(error);
                        alert('Error sending message: ' + error.message);
                    });
            });
        }

        function displayMessage(username, message) {
            var messageDiv = document.createElement('div');
            messageDiv.classList.add('message');
            messageDiv.textContent = `${username}: ${message}`;
            document.getElementById('messages').appendChild(messageDiv);
        }
    </script>
</body>



@endsection