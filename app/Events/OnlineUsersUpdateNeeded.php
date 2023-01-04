<?php

namespace App\Events;

use App\Http\Resources\UserChatResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OnlineUsersUpdateNeeded implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public AnonymousResourceCollection $onlineUsers;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->onlineUsers = UserService::getOnlineUsers();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('users');
    }
}
