// public/chat.js
window.onload = function() {
    const socket = io.connect('http://localhost:3000');

    const messageInput = document.getElementById('message');
    const sendButton = document.getElementById('sendMessage');
    const messagesContainer = document.getElementById('messages');

    sendButton.addEventListener('click', function() {
        const message = messageInput.value;
        socket.emit('chat message', message);  // Kafka orqali xabar yuborish
        messageInput.value = '';
    });

    socket.on('chat message', function(msg) {
        const li = document.createElement('li');
        li.textContent = msg;
        messagesContainer.appendChild(li);
    });
};
