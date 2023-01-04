<?php

namespace App\Services;

use App\Events\OnlineUsersUpdateNeeded;
use App\Http\Resources\UserChatResource;
use App\Models\User;
use App\Repositories\UserRepository;

class UserService
{
    public static float $secondsForOffline = 20;

    public function __construct(protected UserRepository $repository)
    {
    }

    public function updateOnlineStatus()
    {
        $oldOnlineTime = $this->repository->updateOnlineStatus();
        if (empty($oldOnlineTime) || time() - strtotime($oldOnlineTime) > static::$secondsForOffline) {
            broadcast(new OnlineUsersUpdateNeeded());
        }

        return true;
    }

    public static function getOnlineUsers()
    {
        return UserRepository::getOnlineUsers(static::$secondsForOffline);
    }
}
