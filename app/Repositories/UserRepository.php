<?php

namespace App\Repositories;

use App\Http\Resources\UserChatResource;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class UserRepository
{
    public function updateOnlineStatus()
    {
        $user = Auth::user();
        $oldOnline = $user->last_online;
        $user->last_online = 'NOW()';
        $user->save();
        return $oldOnline;
    }

    public static function getOnlineUsers($offlineSeconds)
    {
        $onlineUsers = User::query()->whereNotNull('last_online')
            ->whereRaw("last_online >= NOW() - INTERVAL '$offlineSeconds SECOND'")->get();

        return UserChatResource::collection($onlineUsers);
    }
}
