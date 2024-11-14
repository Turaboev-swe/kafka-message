<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat App</title>
    <script src="/socket.io/socket.io.js"></script>
    <style>
        #messages {
            list-style-type: none;
            padding: 0;
        }
        #messages li {
            padding: 8px;
            margin: 4px 0;
            background-color: #f1f1f1;
            border-radius: 4px;
            max-width: 60%;
        }
        .user {
            background-color: #d1f7d1; /* Foydalanuvchi xabari */
            align-self: flex-start;
        }
        .server {
            background-color: #f0f0f0; /* Server xabari */
            align-self: flex-end;
        }
        #messages {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
        .message-container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
        .message-container.user {
            align-items: flex-start;
        }
        .message-container.server {
            align-items: flex-end;
        }
    </style>
</head>
<body>
<ul id="messages"></ul>
<form id="form" action="">
    <input id="input" autocomplete="off" placeholder="Type a message..." />
    <button>Send</button>
</form>

<script>
    var socket = io(); // Socket.io serverga ulanadi

    // Xabar yuborish
    document.getElementById('form').addEventListener('submit', function(event) {
        event.preventDefault(); // Formni qayta yuklamaslik uchun
        const message = document.getElementById('input').value;
        socket.emit('chat message', message); // Xabarni serverga yuborish
        document.getElementById('input').value = ''; // Inputni tozalash
    });

    // Serverdan kelgan xabarni olish va ekranlashtirish
    socket.on('chat message', function(data) {
        var item = document.createElement('li');
        item.textContent = data.text; // Xabar matnini qo'shish
        item.classList.add(data.sender); // Xabar yuborgan tomonni belgilash
        document.getElementById('messages').appendChild(item); // Xabarni ro'yxatga qo'shish
    });
</script>
</body>
</html>
