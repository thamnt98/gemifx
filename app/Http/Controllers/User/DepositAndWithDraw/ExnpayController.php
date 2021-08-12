<?php

namespace App\Http\Controllers\User\DepositAndWithDraw;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Redirect;
use Telegram\Bot\Laravel\Facades\Telegram;

class ExnpayController extends Controller
{
    public function main(Request $request)
    {
        $url = null;
        $message = '';
        $code = 200;
        $price =  $request->amount_money;
        $login = $request->login;
        $isValid = $this->isValid(['amount_money' => $price, 'login' => $login]);
        if ($isValid->fails()) {
            $code = 400;
            $isValid = $isValid->errors();
        } else {
            $user = Auth::user();
            $isValid = null;
            $data['status'] = config('deposit.status.pending');
            $data['type'] = config('deposit.type.exnpay');
            $data['merchant_id'] = config('deposit.exnpay.merchant_id');
            $data['payment_method_id'] = 0;
            $data['mrc_order_id'] = $data['order_number'] = Str::random(6);
                    $data['mrc_customer'] =  Auth::user()->email;
            $data['url_success'] = route('deposit.bepay');
            $data['sign'] = md5($data['merchant_id'] . $data['mrc_order_id'] . $data['payment_method_id']. $data['mrc_customer'] . $price  .  config('deposit.exnpay.secret_key'));
//                    $data['sign'] = md5($data['merchant_id'] . $data['mrc_order_id'] . $data['merchant_customer'] . $data['amount_money'] . $data['bank_code'] .  config('deposit.bepay.secret_key'));
            $data['amount'] = $price;
            $data['url_cancel'] = $data['url_success'] = $data['webhooks']= route('deposit.funds');
            $endpoint = "https://umediasoft.com/api/order/send";
            $client = new Client();
            $response = $client->post($endpoint, array(
                'form_params' => $data
            ));
            $result = json_decode($response->getBody());
            if ($result->code == 0) {
                $url = $result->data->redirect_url;
                $data['user_id'] = $user->id;
                $data['login'] = $login;
                $data['amount_money'] = $price;
                $data['bank_name'] = $result->data->bank_name;
                Order::create($data);
                $text = "A new Deposit \n"
                . "<b>Email Address: "  . Auth::user()->email . "</b>\n"
                . "<b>Amount money: "  . $price . "</b>\n"
                . "<b>Bank Name: "  . $data['bank_name'] . "</b>\n";
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
                'amount_money' => 'bail|required|numeric|min:100000',
                'login' => 'required'
            ]
        );
    }
}
