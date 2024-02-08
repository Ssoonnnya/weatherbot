<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Telegram\Bot\BotsManager;
use GuzzleHttp\Client;

class WebhookController extends Controller
{

    private BotsManager $botsManager;

    private Client $httpClient;

    public function __construct(BotsManager $botsManager, Client $httpClient){
        $this->botsManager = $botsManager;
        $this->httpClient = $httpClient;
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $webhook = $this->botsManager->bot()->commandsHandler(true);

        $message = $webhook->getMessage();

        $bot = $this->botsManager->bot();

        if($message->isType('location'))
        {
            $location = $message-> location;
            $chat = $message-> chat;

            $weatherInfo = $this->weatherInformation($location->longitude, $location->latitude);

            $bot-> sendMessage([
                'chat_id' => $chat->id,
                'text' => $weatherInfo,
            ]);
        }

        return response(null, Response::HTTP_OK);
    }

    private function weatherInformation($latitude, $longitude){

        $apiToken = env('WEATHER_TOKEN');

        $requestUrl =  "https://api.openweathermap.org/data/2.5/weather?lat={$latitude}&lon={$longitude}&appid={$apiToken}";
        $response = $this->httpClient->get($requestUrl);

        $data = json_decode($response->getBody(), false, 512, JSON_THROW_ON_ERROR);

        $city = $data->name . "\n\n";
        $temp = $data->main->temp . "℃\n";
        $pressure = $data->main->pressure . "℃\n";
        $humidity = $data->main->humidity . "℃\n";

        $weatherInfo = 'Місто : ' . $city;
        $weatherInfo .= 'Температура повітря : ' . $temp;
        $weatherInfo .= 'Атмосферній тиск : ' . $pressure;
        $weatherInfo .= 'Вологість повітря : ' . $humidity;

        return $response;
    }
}
