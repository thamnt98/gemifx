<?php

namespace App\Http\Controllers\User\Account;

use App\Http\Controllers\Controller;
use App\Models\Order;
use TigerpaySDK\TigerpayClient;

use TigerpaySDK\TigerpayTradeWapObj;
use TigerpaySDK\TigerpayTradeWapReq;

use TigerpaySDK\TigerpayTradeWappayObj;
use TigerpaySDK\TigerpayTradeWappayReq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class TransferByVifaController extends Controller
{
    public function main(Request $request)
    {
        $url = null;
        $message = '';
        $code = 200;
        $isValid = null;
        $price =  $request->amount_money;
        $isValid = $this->isValid(['amount_money' => $price]);
        if ($isValid->fails()) {
            $code = 400;
            $isValid = $isValid->errors();
        } else {
            $user = Auth::user();
            $order = Order::create(
                [
                    'user_id' => $user->id,
                    'amount_money' => $price,
                ]
            );
            $serverUrl = config('vifa.server_url');
            $appId = config('vifa.app_id');
            $APPPrivateKEY  = config('vifa.app_private_key');
            $ServerPublicKey = config('vifa.server_public_key');
            $client = new TigerpayClient($serverUrl, $appId, $APPPrivateKEY, $ServerPublicKey);
            $wapObj = new TigerpayTradeWapObj();
            $wapObj->userName = $user->full_name;
            $wapObj->userId = $user->id;
            $wapObj->price = $price;
            $wapObj->tradeNo = $order->id;
            $request = new TigerpayTradeWapReq($wapObj);
            $url = $client->sdkExecute($request);
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
                'amount_money' => 'bail|required|numeric|min:10000'
            ]
        );
    }
}