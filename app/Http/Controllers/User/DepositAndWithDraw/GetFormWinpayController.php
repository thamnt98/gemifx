<?php

namespace App\Http\Controllers\User\DepositAndWithDraw;

use App\Http\Controllers\Controller;
use App\Models\LiveAccount;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GetFormWinpayController extends Controller
{
    public function main(){
        $apiKey = config('deposit.winpay.api_key');
        $endpoint = "https://vwinpay.com/api/info?api_key=" . $apiKey;
        $client = new Client();
        $response = $client->request('GET', $endpoint);
        $result = json_decode($response->getBody());
        $logins = LiveAccount::where('user_id', Auth::user()->id)->pluck('login');
        if ($result->code == 1){
            $code = Str::random('24');
            $bankInfo = $result;
            return view('withdrawanddeposit.winpay', compact('bankInfo', 'logins', 'code'));
        }
        return redirect()->back()->with('error', 'Something went wrong. Please try again later');
    }
}
