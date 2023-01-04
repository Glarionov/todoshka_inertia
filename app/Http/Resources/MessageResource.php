<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class MessageResource extends JsonResource
{
    public bool $preserveKeys = true;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'user_id' => $this->user->id,
            'user_name'=> $this->user->name,
            'created_at' => date("H:i:s m.d.Y", strtotime($this->created_at)),
            'own' => $this->user->id == Auth::id()
        ];
    }
}
