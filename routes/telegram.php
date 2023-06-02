<?php

/** @var SergiX44\Nutgram\Nutgram $bot */

use App\Http\Controllers\BotConversation;
use App\Models\Button;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;


$keyboardMarkup = InlineKeyboardMarkup::make();
$buttons = Button::query()->get();

$buttons
    ->groupBy('row')
    ->each(function ($rowButtons) use ($keyboardMarkup) {
        $inlineButtons = [];


        foreach ($rowButtons->sortByDesc('priority') as $rowButton) {
            $inlineButtons[] =  $rowButton->type === Button::TYPE_URL
                ? InlineKeyboardButton::make($rowButton->title, callback_data: 'url')
                : InlineKeyboardButton::make('Callable action', callback_data: 'callable')
            ;
        }

        $keyboardMarkup->addRow(...$inlineButtons);
    })
;

$bot->onCommand('start', function(Nutgram $bot) use ($keyboardMarkup) {
    $bot->sendMessage('Dynamic menu', ['reply_markup' => $keyboardMarkup]);
});

$bot->onCallbackQueryData('url', function(Nutgram $bot){
    $bot->sendMessage('Url button', [
        'reply_markup' => InlineKeyboardMarkup::make()
            ->addRow(InlineKeyboardButton::make('Google', url: 'google.com'))
    ]);
});

$bot->onCallbackQueryData('callable', BotConversation::class);
