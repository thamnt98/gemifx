<?php

namespace App\Http\Controllers\User\DepositAndWithDraw;

use App\Http\Controllers\Controller;
use App\Models\Order;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Telegram\Bot\Laravel\Facades\Telegram;

class WinpayTransferController extends Controller
{
    public function main(Request $request)
    {
        $data = $request->except("_token");
        $isValid = $this->isValid($data);
        if ($isValid->fails()) {
            return redirect()->back()->withErrors($isValid->errors())->withInput();
        }
        $user = Auth::user();
        $data['bank_name'] = $data['bank_code'];
        $text = "A new Deposit \n"
            . "<b>Email Address: " . Auth::user()->email . "</b>\n"
            . "<b>Amount money: " . $data['amount_money'] . "</b>\n"
            . "<b>Bank Name: " . $data['bank_name'] . "</b>\n";
        $data['user_id'] = $user->id;
        $data['status'] = config('deposit.status.pending');
        $data['type'] = config('deposit.type.winpay');
        Telegram::sendMessage([
            'chat_id' => config('telegram.TELEGRAM_CHANNEL_ID'),
            'parse_mode' => 'HTML',
            'text' => $text
        ]);
        if (strtotime(now()) - strtotime($data['expire_time']) > 900) {
            return redirect()->back()->with('error', "Giao dịch của bạn đã quá 15 phút và bị hết hạn. Vui lòng refresh lại trang để tiếp tục");
        }
        Order::create($data);
        return redirect()->back()->with('success', "Bạn đã xác nhận chuyển khoản thành công!");
    }

    private function isValid($data)
    {
        return Validator::make(
            $data,
            [
                'amount_money' => 'required|min:150000|numeric',
                'login' => 'required'
            ]
        );
    }

}
