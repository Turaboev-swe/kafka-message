<!-- resources/views/chat.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Room</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.0.1/socket.io.js"></script>
    <script src="{{ asset('chat.js') }}"></script>
</head>
<body>
<h1>Chat Room</h1>
<ul id="messages"></ul>
<input type="text" id="message" placeholder="Type a message...">
<button id="sendMessage">Send</button>
</body>
</html>
