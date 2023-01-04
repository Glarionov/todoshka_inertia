<?php

namespace Database\Seeders;

use App\Models\Message;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 41; $i++) {
            $message = new Message();
            $message->user_id = floor($i / 4 + 1);
            $message->text = 'Message_____________________' . $i;
            $message->save();
        }
    }
}
