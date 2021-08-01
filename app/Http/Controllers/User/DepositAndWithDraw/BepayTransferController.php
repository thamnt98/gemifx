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

class BepayTransferController extends Controller
{
    public function main(Request $request)
    {
        $data = $request->except("_token");
        $isValid = $this->isValid($data);
        if ($isValid->fails()) {
            return redirect()->back()->withErrors($isValid->errors())->withInput();
        }
        $user = Auth::user();
        $data['bank'] = explode('-', $data['bank']);
        $data['bank_code'] = $data['bank'][0];
        $data['bank_name'] = $data['bank'][1];
        $text = "A new Deposit \n"
            . "<b>Email Address: "  . Auth::user()->email . "</b>\n"
            . "<b>Amount money: "  . $data['amount_money'] . "</b>\n"
            . "<b>Bank Name: "  . $data['bank_name'] . "</b>\n";
        unset($data['bank']);
        $data['user_id'] = $user->id;
        $data['status'] = config('deposit.status.pending');
        $data['type'] = config('deposit.type.bepay');
        $data['merchant_id'] = config('deposit.bepay.merchant_id');
        $data['payment_method'] = 1;
        $data['merchant_txn'] = $data['order_number'] = Str::random(6);
        //        $data['merchant_customer'] =   str_replace(' ', '_', $user->full_name);
        $data['url_success'] = route('deposit.bepay');
        $data['sign'] = md5($data['merchant_id'] . $data['merchant_txn'] . $data['amount_money'] . $data['bank_code'] .  config('deposit.bepay.secret_key'));
        //        $data['sign'] = md5($data['merchant_id'] . $data['merchant_txn'] . $data['merchant_customer'] . $data['amount_money'] . $data['bank_code'] .  config('deposit.bepay.secret_key'));
        $data['amount'] = $data['amount_money'];
        Telegram::sendMessage([
            'chat_id' => config('telegram.TELEGRAM_CHANNEL_ID'),
            'parse_mode' => 'HTML',
            'text' => $text
        ]);
        $endpoint = "https://bepay2.com/api/v2/payment/request";
        $client = new Client();
        $response = $client->post($endpoint, array(
            'form_params' => $data
        ));
        $result = json_decode($response->getBody());
        if (isset($result->data->redirect_url) && $result->data->redirect_url) {
            Order::create($data);
            return Redirect::to($result->data->redirect_url);
        }
        return redirect()->back()->withInput();
    }

    private function isValid($data)
    {
        return Validator::make(
            $data,
            [
                'amount_money' => 'required|min:150000|numeric',
                'bank' => 'required',
                'login' => 'required'
            ]
        );
    }
}
