<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Telegram\Bot\BotsManager;

class WebhookController extends Controller
{

    private BotsManager $botsManager;

    public function __construct(BotsManager $botsManager){
        $this->botsManager = $botsManager;
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $webhook = $this->botsManager->bot()->commandsHandler(true);

        return response(null, Response::HTTP_OK);
    }
}
