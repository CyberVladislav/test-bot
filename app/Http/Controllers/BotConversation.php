<?php

namespace App\Http\Controllers;

use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;

class BotConversation extends Conversation
{
    public function start(Nutgram $bot)
    {
        $bot->sendMessage('Bot answer!');
        $this->end();
    }
}
