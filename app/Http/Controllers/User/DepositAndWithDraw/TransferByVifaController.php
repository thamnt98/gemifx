<?php

namespace App\Http\Controllers\User\DepositAndWithDraw;

use App\Http\Controllers\Controller;
use App\Models\Order;
use TigerpaySDK\TigerpayClient;

use TigerpaySDK\TigerpayTradeWapObj;
use TigerpaySDK\TigerpayTradeWapReq;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Str;

class TransferByVifaController extends Controller
{
    public function main(Request $request)
    {
        $url = null;
        $message = '';
        $code = 200;
        $isValid = null;
        $price =  $request->amount_money;
        $login = $request->login;
        $isValid = $this->isValid(['amount_money' => $price, 'login' => $login]);
        if ($isValid->fails()) {
            $code = 400;
            $isValid = $isValid->errors();
        } else {
            $user = Auth::user();
           
            $serverUrl = config('deposit.vifa.server_url');
            $appId = config('deposit.vifa.app_id');
            $APPPrivateKEY  = config('deposit.vifa.app_private_key');
            $ServerPublicKey = config('deposit.vifa.server_public_key');
            $client = new TigerpayClient($serverUrl, $appId, $APPPrivateKEY, $ServerPublicKey);
            $wapObj = new TigerpayTradeWapObj();
            $wapObj->userName = $user->full_name;
            $wapObj->userId = $user->id;
            $wapObj->price = $price;
            $wapObj->tradeNo = Str::random(6);
            $request = new TigerpayTradeWapReq($wapObj);
            $url = $client->sdkExecute($request);
            if($url){
                $order = Order::create(
                    [
                        'user_id' => $user->id,
                        'amount_money' => $price,
                        'type' => config('deposit.type.vifa'),
                        'status' => config('deposit.status.pending'),
                        'login' => $login,
                        'order_number' => $wapObj->tradeNo,
                    ]
                );
                $text = "A new Deposit \n" .
                    "<b>Email Address: "  . Auth::user()->email . "</b>\n"
                    . "<b>Login: "  . $login . "</b>\n"
                    . "<b>Amount money: "  . $price . "</b>\n";
                Telegram::sendMessage([
                    'chat_id' => config('telegram.TELEGRAM_CHANNEL_ID'),
                    'parse_mode' => 'HTML',
                    'text' => $text
                ]);
            }
        }
        return json_encode(
            [
                'data' => $isValid,
                'message' => $message,
                'url' => $url,
                'status' => $code
            ]
        );
    }

    private function isValid($data)
    {
        return Validator::make(
            $data,
            [
                'amount_money' => 'bail|required|numeric|min:10000',
                'login' => 'required'
            ]
        );
    }
}
