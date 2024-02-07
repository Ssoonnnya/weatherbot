<?php

namespace App\Commands;

use Telegram\Bot\Commands\Command;

class StartCommand extends Command
{
   protected string $name = 'start';

   protected string $description = 'Start command';

    public function handle()
    {
        $this->replyWithMessage([
            'text' => 'Привіт! Ласкаво прошу до телеграм каналу з погодою!',
        ]);
    }
}
