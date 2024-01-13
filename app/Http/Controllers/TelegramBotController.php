<?php

namespace App\Http\Controllers\Api\Common;

use App\Services\TelegramBot;
use App\Services\TelegramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Author: Nizomiddin Zaripov
 * Date: 29/10/23 23:48
 * nizomiddinzaripov@yandex.com
 **/
class TelegramBotController
{
    public TelegramBot $bot;

    public static $HISTORY_PREFIX = 'bot_history_';

    public static $START       = 'start';
    public static $CONTACT     = 'contact';
    public static $CONFIRM_SMS = 'confirm_sms';

    public function __invoke(Request $request)
    {
        $this->bot = TelegramBot::createBot(config('telegram.bot_token'))->handleRequest($request);
        Log::info('bot', $request->all());

        if ($this->bot->getText() == '/start') {
            $this->putHistory(self::$START);
            TelegramService::welcomeReply($this->bot);

            return;
        }

        if ($this->checkHistory(self::$START) && $this->bot->hasContact()) {
            $this->putHistory(self::$CONTACT);
            TelegramService::createMember($this->bot);

            return;
        }

        if ($this->checkHistory(self::$CONTACT) && cache()->has('sms_confirm_' . $this->bot->getChatId())) {
            TelegramService::confirmSms($this->bot);

            return;
        }

        $this->bot->reply(__('telegram.command_not_found'));
    }

    public function putHistory(string $history)
    {
        cache()->put(self::$HISTORY_PREFIX . $this->bot->getChatId(), $history);
    }

    public function checkHistory(string $history)
    {
        $cacheHistory = cache()->get(self::$HISTORY_PREFIX . $this->bot->getChatId());

        return $cacheHistory == $history;
    }

}
