<?php

namespace App\Repositories;

use App\Models\Message;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class MessageRepository
{
    protected $itemsPerPage = 30;

    /**
     * Gel list of the messages
     *
     * @param $requestData
     * @return mixed
     */
    public function getList($requestData)
    {
        return Message::query()->when($requestData['message_id'] ?? null,
            function (Builder $query, string $messageId): void {
                $query->where('id', '<', $messageId);
        })->take($this->itemsPerPage)->orderBy('id', 'desc')->get()->keyBy('id');
    }

    public function store($requestData)
    {
        $message = new Message();
        $message->text = $requestData['text'];
        $message->user_id = Auth::id();
        $message->save();
        return $message;
    }
}
