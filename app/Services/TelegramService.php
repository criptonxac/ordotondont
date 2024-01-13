<?php

namespace App\Services;

use App\Enums\OrderFromTypeEnum;
use App\Enums\OrderStatusEnum;
use App\Enums\TariffSlugEnum;
use App\Enums\UserRoleEnum;
use App\Jobs\SendOrderToDriver;
use App\Models\Tariff;
use App\Models\User;
use App\Models\UserRating;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Models\Address;
use App\Models\Order;
use App\Models\DriverPlan;
use App\Jobs\OrderSendToDriver;
use App\Models\Client;
use Carbon\Carbon;

/**
 * Author: Nizomiddin Zaripov
 * Date: 30/10/23 00:58
 * nizomiddinzaripov@yandex.com
 **/
class TelegramService
{
    public static $PHONE_PREFIX = 'bot_phone_';

    public static function requestContact($bot)
    {
        $keyboard['keyboard']        = [
            [
                [
                    'text'            => __('telegram.ask_phone'),
                    'request_contact' => true,
                ],
            ],
        ];
        $keyboard['resize_keyboard'] = true;

        $bot->sendMessage(
            $bot->getChatId(),
            "📞 Iltimos, telefon raqamingizni yuboring. \n❗️ Hozirda ishlayotgan telefon raqamni kiriting.",
            'HTML',
            json_encode($keyboard)
        );
    }

    public static function makeOrder($bot)
    {
        $keyboard['keyboard']        = [
            [
                [
                    'text'             => __('telegram.make_order'),
                    'request_location' => true,
                ],
            ],
        ];
        $keyboard['resize_keyboard'] = true;

        $client = User::query()->whereHasRole(UserRoleEnum::member->value)
            ->where('telegram_id', $bot->getChatId())->with('detail', 'wallet')->first();

        $info = "📞 Raqamingiz: <b>+{$client->detail->phone}</b>\n💰 Bonus holati: <b>{$client->wallet->balance} so'm</b>";

        $bot->reply($info);

        $bot->sendMessage(
            $bot->getChatId(),
            'Tanlang: 👇',
            'HTML',
            json_encode($keyboard)
        );
    }

    public static function stat($bot)
    {
        $orderCount = Order::query()->whereNotNull('bot_chat_id')
            ->whereDate('create_time', '>=', now()->subHours(24))->count();
        $canceled   = Order::query()->whereNotNull('bot_chat_id')
            ->whereDate('create_time', '>=', now()->subHours(24))
            ->where('status', OrderStatusEnum::canceled->value)->count();
        $success    = Order::query()->whereNotNull('bot_chat_id')
            ->whereDate('create_time', '>=', now()->subHours(24))
            ->where('status', OrderStatusEnum::completed->value)->count();

        $clients = User::query()->whereHasRole(UserRoleEnum::member->value)->whereNotNull('telegram_id')->count();

        $onlineDrivers = sizeof(getDriverLocations());

        $message = "Oxirgi 24 soatdagi buyurtmalar

🔹Umumiy:<b> $orderCount</b>
❌Bekor qilingan:<b> $canceled</b>
✅Yakunlangan: <b> $success</b>

🔵Mijozlar soni: <b> $clients</b>

🟢Online haydovchilar: <b> $onlineDrivers</b>";
        $bot->reply($message);
    }

    public static function checkPhone($bot)
    {
        $phone = $bot->getText();
        $phone = str_replace('+', '', $phone);
        if (strlen($phone) == 9) {
            $phone = '998' . $phone;
        }

        if ($bot->hasContact()) {
            $phone = str_replace('+', '', $bot->getContact());
        }

        if (!is_numeric($phone) || strlen($phone) != 12) {
            $bot->reply("❗️ Telefon raqam notog'ri kiritildi. Iltimos, qaytadan urinib ko'ring.");

            return false;
        }

        $client = User::query()->whereRelation('detail', 'phone', $phone)
            ->whereHasRole(UserRoleEnum::member->value)->first();

        if (!$client) {
            $client = User::query()->create(['username' => uuid_create()]);
            $client->detail()->create(['phone' => $phone]);
            $client->addRole(UserRoleEnum::member->value);
            $client->wallet()->update(['bonus_code' => rand(1000, 9999)]);
        }

        $client->update(['branch_id' => 1, 'telegram_id' => $bot->getChatId()]);

        $bot->reply("✅ Qabul qilindi!");

        return true;
    }


    public static function createOrder($bot, $token)
    {
        if (!$bot->hasLocation()) {
            $bot->reply("❌ Xatolik, qaytadan urinib ko'ring.");

            return false;
        }

        $lat = $bot->location->latitude;
        $lon = $bot->location->longitude;

        $address = Address::selectRaw("*,
        ACOS(SIN(RADIANS(lat))*SIN(RADIANS($lat)) +
         COS(RADIANS(lat))*COS(RADIANS($lat)) *
         COS(RADIANS(lon) - RADIANS($lon)))*6380 AS distance")
            ->orderBy('distance', 'ASC')
            ->first();


        $tariffSlug  = TariffSlugEnum::EKONOM->value;
        $currentTime = Carbon::now();

        $startTime1 = Carbon::parse('23:00:00');
        $endTime1   = Carbon::parse('23:59:00');

        $startTime2 = Carbon::parse('00:00:00');            // 11:00 PM
        $endTime2   = Carbon::parse('07:00:00');

        if ($currentTime->between($startTime1, $endTime1) || $currentTime->between($startTime2, $endTime2)) {
            $tariffSlug = TariffSlugEnum::NOCH->value;
        }

        $client = User::query()->with('detail', 'wallet')->whereHasRole(UserRoleEnum::member->value)
            ->where('telegram_id', $bot->getChatId())->first();

        if (!$client) {
            $bot->reply("❌ Xatolik, qaytadan urinib ko'ring.\n\n/start");

            return false;
        }

        $tariff = Tariff::query()->where('slug', $tariffSlug)->first();
        $order  = new Order();

        $order->branch_id = 1;
        $order->name      = '';
        $order->tariff_id = $tariff->id;
        $order->client_id = $client->id;
        $order->start_lat = $lat;
        $order->start_lon = $lon;

        $order->status        = OrderStatusEnum::active->value;
        $order->begin_price   = $tariff->begin_price;
        $order->plus_price    = $address->plus_sum;
        $order->create_time   = now();
        $order->where_is_from = OrderFromTypeEnum::bot->value;

        $order->start_address_id = $address->id;
        $order->bot_chat_id      = $bot->getChatId();
        $order->bot_token        = $token;

        $order->save();

        $message = "📌 Buyurtma raqami: <b>#{$order->id}</b>
📞 Telefon raqam: <b>+{$client->detail->phone}</b>
📍Manzil: <b>{$address->title}</b>
🚗 Tarif: <b>{$tariff->title}</b>
🔹 Holati: <b>Aktiv</b>
💸 Bonus holati: <b>{$client->wallet->balance} so'm</b>
🤳Bonus kodi: <b>{$client->wallet->bonus_code}</b>\n
🔎 Haydovchi Qidirilmoqda
";

        $keyboard['inline_keyboard'] = [
            [

                [
                    "text"          => "❌ Bekor qilish",
                    "callback_data" => "cancel_order-" . $order->id,
                ],
            ],
        ];


        $res = $bot->sendMessage(
            $bot->getChatId(),
            $message,
            'HTML',
            json_encode($keyboard)
        );

        $resData = json_decode($res->body(), true);

        $order->update(['bot_message_id' => $resData['result']['message_id']]);

        $keyboard['keyboard']        = [
            [
                [
                    'text'             => __('telegram.make_order'),
                    'request_location' => true,
                ],
            ],
        ];
        $keyboard['resize_keyboard'] = true;
        $bot->sendMessage(
            $bot->getChatId(),
            '✅ Buyurtma yaratildi. Agar buyurtmada xatolik bo\'lsa bekor qilish tugmasini bosing.',
            'HTML',
            json_encode($keyboard)
        );

        cache()->put('order-' . $bot->getChatId(), $order->order_id, now()->addMinute());

        dispatch(new SendOrderToDriver($order->id))->onConnection('database')->onQueue('default');

        return true;
    }

    public static function rateOrder($bot, $orderId, $rate)
    {
        $order            = Order::query()->find($orderId);
        $data['rater_id'] = $order->client_id;
        $data['rated_id'] = $order->driver_id;
        $data['order_id'] = $order->id;

        UserRating::query()->updateOrCreate($data, ['value' => $rate]);

        $messageId = $order->bot_message_id;
        $chatId    = $order->bot_chat_id;
        $keyboard['inline_keyboard'] = [];
        $bot->editMessageReplyMarkup($chatId,$messageId,json_encode($keyboard));

        $bot->reply("✅ Qabul qilindi.");
    }

    public static function cancelOrder($bot, $orderId)
    {
        $order = Order::query()
            ->where('status', OrderStatusEnum::active->value)
            ->where('id', $orderId)->first();

        if (!$order) {
            $bot->reply("❗️Hurmatli mijoz, buyurtmani bekor qilishni iloji bo'lmadi. Operatorga murojaat qiling.");

            return;
        }

        $tariff  = Tariff::query()->where('id', $order->tariff_id)->first();
        $address = Address::query()->where('id', $order->start_address_id)->first();
        $client  = User::query()->with('detail')->where('id', $order->client_id)->first();

        $message   = "📌 Buyrtma raqami: <b>#{$orderId}</b>
📞 Telefon raqam: <b>+{$client->detail->phone}</b>
📍Manzil: <b>{$address->title}</b>
🚗 Tarif: <b>{$tariff->title}</b>
🔹 Holati: ❌ <b>Bekor qilingan</b>
";
        $messageId = $order->bot_message_id;
        $chatId    = $order->bot_chat_id;

        $bot->editMessageText(
            $chatId,
            $messageId,
            $message
        );

        $order->update(['status' => OrderStatusEnum::canceled->value]);
        if ($order->driver_id){
            User::query()->where('id',$order->driver_id)
                ->update(['status' => OrderStatusEnum::active->value]);
        }

        $bot->reply("Hurmatli mijoz, <b>#{$orderId}</b> raqamli buyurtma bekor qilindi.");
    }

    public static function putPhone($chatId, $phone)
    {
        cache()->put(self::$PHONE_PREFIX . $chatId, $phone);
    }

    public static function getPhone($chatId)
    {
        return cache()->get(self::$PHONE_PREFIX . $chatId);
    }
}
