<?php

namespace App\Console\Commands;

use App\Events\OnlineUsersUpdateNeeded;
use Illuminate\Console\Command;

class updateOnlineUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:update_online_users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Broadcasts event with current online users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        broadcast(new OnlineUsersUpdateNeeded());
        return Command::SUCCESS;
    }
}
