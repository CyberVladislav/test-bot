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
    ->sortDesc()
    ->each(function ($rowButtons) use ($keyboardMarkup) {
        $inlineButtons = [];

        foreach ($rowButtons->sortByDesc('priority') as $rowButton) {
            $inlineButtons[] = InlineKeyboardButton::make($rowButton->title, callback_data: $rowButton->callback_data);
        }

        $keyboardMarkup->addRow(...$inlineButtons);
    })
;

foreach ($buttons as $button) {
    if (!$button->url) {
        $bot->onCallbackQueryData($button->callback_data, BotConversation::class);

        continue;
    }

    $bot->onCallbackQueryData($button->callback_data, function (Nutgram $bot) use ($button) {
        $bot->sendMessage($button->url_button_text, [
            'reply_markup' => InlineKeyboardMarkup::make()
                ->addRow(InlineKeyboardButton::make($button->url_button_text, $button->url))
        ]);
    });
}

$bot->onCommand('start', function (Nutgram $bot) use ($keyboardMarkup) {
    $bot->sendMessage('Dynamic menu', ['reply_markup' => $keyboardMarkup]);
});

