<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class TaskResource extends JsonResource
{
    public bool $preserveKeys = true;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'done' => $this->done
        ];
    }
}
