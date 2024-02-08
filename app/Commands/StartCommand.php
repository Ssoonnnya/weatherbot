<?php

namespace App\Commands;

use Telegram\Bot\Commands\Command;
use Telegram\Bot\Actions;


class StartCommand extends Command
{
   protected string $name = 'start';

   protected string $description = 'Start command';

    public function handle()
    {
        $this->replyWithMessage([
            'text' => 'Привіт! Ласкаво прошу до телеграм боту з погодою!',
        ]);

        $this->replyWithChatAction([
            'action' => Actions::TYPING,
        ]);

        $response = '';
        $commands = $this->getTelegram()->getCommands();

        foreach ($commands as $name => $command) {
            $response .= sprintf('/%s - %s' . PHP_EOL, $name, $command->getDescription());
        }

        $this->replyWithMessage([
            'text' => $response,
        ]);
    }
}
