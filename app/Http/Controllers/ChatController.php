<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class ChatController extends Controller
{
    /**
     * @param UserService $userService
     * @return \Inertia\Response
     */
    public function index(UserService $userService)
    {
        $userService->updateOnlineStatus();
        $onlineUsers = UserService::getOnlineUsers();
        return Inertia::render('Chat/ChatRoom', ['initialOnlineUsers' => $onlineUsers]);
    }

    /**
     * @param UserService $userService
     * @return bool[]
     */
    public function updateOnlineStatus(UserService $userService)
    {
        $userService->updateOnlineStatus();
        return ['success' => true];
    }
}
