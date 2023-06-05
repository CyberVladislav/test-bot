<?php

namespace App\Http\Controllers;

use SergiX44\Nutgram\Nutgram;

class BotConversation
{
    public function __invoke(Nutgram $bot)
    {
        $bot->sendMessage('Bot answer!');
        $bot->endConversation();
    }
}
