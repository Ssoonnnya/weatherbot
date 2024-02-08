<?php

namespace App\Commands;

use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Keyboard\Button;



class WeatherCommand extends Command
{

    protected string $name = 'Wweather';

    protected string $description = 'Інформація про погоду.';

    public function handle()
    {
        $keyboard = new Keyboard();

        $button = Keyboard::button([
            'text' => 'Надіслати розташування',
            'request_location' => true,
        ]);

        $keyboard->setResizeKeyboard(true);
        $keyboard->setOneTimeKeyboard(true);

        $keyboard->row([$button]);

        $this->replyWithMessage([
            'text' => 'Для отримання інформації про погоду натисніть кнопку',
            'reply_markup' => $keyboard,
        ]);
    }
}
