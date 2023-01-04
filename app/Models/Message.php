<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    /**
     * Get the user that owns the message.
     */
    public function user(): object
    {
        return $this->belongsTo(User::class);
    }
}
