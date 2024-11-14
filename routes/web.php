<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;

Route::get('/', function () {
    return view('chat');
});

Route::get('/client', function () {
    return view('client');
});
