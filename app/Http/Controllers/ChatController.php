<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class ChatController extends Controller
{
    public function index()
    {
        return Inertia::render('Chat/ChatWelcome', []);
    }

    public function openChatRoom(int $id)
    {

        return Inertia::render('Chat/ChatRoom', []);
    }
}
