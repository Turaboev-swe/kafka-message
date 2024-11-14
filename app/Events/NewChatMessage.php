<?php
// app/Events/NewChatMessage.php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class NewChatMessage
{
    use SerializesModels;

    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }
}

