const { Kafka } = require('kafkajs');
const express = require('express');
const http = require('http');
const socketIo = require('socket.io');

const app = express();
const server = http.createServer(app);
const io = socketIo(server);

// Kafka sozlamalari
const kafka = new Kafka({
    clientId: 'chat-app',
    brokers: ['localhost:9092'],  // Kafka broker manzili
});

const producer = kafka.producer();
const consumer = kafka.consumer({ groupId: 'chat-group' });

// Kafka producer va consumer ulanishi
async function runProducer() {
    await producer.connect();
}

async function runConsumer() {
    await consumer.connect();
    await consumer.subscribe({ topic: 'chat-messages', fromBeginning: true });

    consumer.run({
        eachMessage: async ({ message }) => {
            const msg = message.value.toString();
            // Server xabarini barcha foydalanuvchilarga yuborish
            io.emit('chat message', { text: msg, sender: 'server' }); // 'server' xabarni yuborgan tomonni bildiradi
        },
    });
}

io.on('connection', (socket) => {
    console.log('Foydalanuvchi ulandi');

    socket.on('chat message', async (msg) => {
        console.log('Jo\'natilgan xabar:', msg);
        // Kafka producer orqali xabarni Kafka topiga yuborish
        await producer.send({
            topic: 'chat-messages',
            messages: [{ value: msg }],
        });

        // Foydalanuvchi yuborgan xabarni barcha foydalanuvchilarga yuborish
        io.emit('chat message', { text: msg, sender: 'user' }); // 'user' xabarni yuborgan tomonni bildiradi
    });

    socket.on('disconnect', () => {
        console.log('Foydalanuvchi uzildi');
    });
});

// Kafka producer va consumer ishga tushiriladi
runProducer().catch(console.error);
runConsumer().catch(console.error);

// Serverni ishga tushurish
server.listen(3000, () => {
    console.log('Listening on http://localhost:3000');
});
