<?php
// app/Http/Controllers/ChatController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
public function index(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
{
return view('chat');
}

public function sendMessage(Request $request): void
{
// Xabarni Kafka-ga yuborish yoki boshqa manzilga yo'naltirish
event(new \App\Events\NewChatMessage($request->message));  // Event orqali yuborish
}
}
