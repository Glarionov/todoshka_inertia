<?php

namespace App\Http\Requests\Message;

use Illuminate\Foundation\Http\FormRequest;

class GetListMessageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'message_id' => ['int', 'nullable', 'exists:messages,id'],
        ];
    }
}
