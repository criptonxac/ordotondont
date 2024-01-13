<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramBot
{
    public $callback = null;
    public $message  = null;
    public $chat     = null;
    public $entities = null;
    public $contact  = null;
    public $location = null;
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * @param string $token
     *
     * @return static
     */
    public static function createBot($token)
    {
        return new static($token);
    }

    /**
     * @param Request $request
     *
     * @return $this
     */
    public function handleRequest(Request $request)
    {
        if ($request->has('callback_query')) {
            $this->callback = (object)$request->get('callback_query');
            $this->message  = (object)$this->callback->message;
            $this->chat     = (object)$this->message->chat;
        } else {
            if ($request->has('message')) {
                $this->message = (object)$request->get('message');
            }

            if (isset($this->message->chat)) {
                $this->chat = (object)$this->message->chat;
            }

            if (isset($this->message->contact)) {
                $this->contact = (object)$this->message->contact;
            }

            if (isset($this->message->location)) {
                $this->location = (object)$this->message->location;
            }

            if (isset($this->message->entities)) {
                $this->entities = (object)$this->message->entities;
            }
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function hasContact()
    {
        return isset($this->contact);
    }

    /**
     * @return string
     */
    public function getContact()
    {
        return isset($this->contact->phone_number) ? $this->contact->phone_number : '';
    }

    /**
     * @return bool
     */
    public function hasLocation()
    {
        return isset($this->location);
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->message->text ?? '';
    }

    /**
     * @return mixed
     */
    public function getChatId()
    {
        return $this->chat->id;
    }

    /**
     * @return mixed
     */
    public function getMemberName()
    {
        return $this->chat->first_name;
    }

    /**
     * @param string $text
     * @param string $parse_mode
     * @param $reply_markup
     *
     * @return Response
     */
    public
    function reply(
        string $text,
        string $parse_mode = 'HTML',
        $reply_markup = null
    ) {
        return $this->sendMessage($this->chat->id, $text, $parse_mode, $reply_markup);
    }

    /**
     * @param int $chat_id
     * @param string $text
     * @param string $parse_mode
     * @param $reply_markup
     *
     * @param bool $disable_web_page_preview
     * @param bool $disable_notification
     * @param bool|null $reply_to_message_id
     *
     * @return Response
     */
    public
    function sendMessage(
        int $chat_id,
        string $text,
        string $parse_mode = 'HTML',
        $reply_markup = null,
        bool $disable_web_page_preview = true,
        bool $disable_notification = false,
        bool $reply_to_message_id = null
    ) {
        return $this->sendTelegram(compact(
                                       'chat_id',
                                       'text',
                                       'parse_mode',
                                       'disable_web_page_preview',
                                       'disable_notification',
                                       'reply_to_message_id',
                                       'reply_markup'
                                   ));
    }


    /**
     * @param int $chat_id
     * @param int $message_id
     * @param string $text
     * @param string $parse_mode
     * @param  $reply_markup
     *
     * @return Response
     */
    public
    function editMessageText(
        int $chat_id,
        int $message_id,
        string $text,
        string $parse_mode = 'HTML',
        $reply_markup = null
    ) {
        return $this->sendTelegram(compact([
                                               'chat_id',
                                               'message_id',
                                               'text',
                                               'parse_mode',
                                               'reply_markup']), 'editMessageText');
    }

    /**
     * @param int $chat_id
     * @param int $message_id
     * @param $reply_markup
     *
     * @return Response
     */
    public function editMessageReplyMarkup(
        int $chat_id,
        int $message_id,
        $reply_markup = null,
        $inline_message_id = null
    ) {
        return $this->sendTelegram(compact([
                                               'chat_id',
                                               'message_id',
                                               'reply_markup',
                                               'inline_message_id',
                                           ]), 'editMessageReplyMarkup');
    }

    /**
     * @param int $chat_id
     * @param int $message_id
     *
     * @return Response
     */
    public function deleteMessage(
        int $chat_id,
        int $message_id
    ) {
        return $this->sendTelegram(compact([
                                               'chat_id',
                                               'message_id',
                                           ]), 'deleteMessage');
    }

    /**
     * @param array $data
     * @param string $method
     *
     * @return Response
     */
    private
    function sendTelegram(
        array $data,
        string $method = 'sendMessage'
    ) {
        $res = Http::post('https://api.telegram.org/bot' . $this->token . '/' . $method . '?' . http_build_query($data));

        return $res;
    }
}
