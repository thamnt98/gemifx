<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\LiveAccount;
use App\Models\Order;
use App\Models\WithdrawalFund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helper\MT5Helper;

class HomeController extends Controller
{
    /**
     * @var mT5Helper
     */
    private $mT5Helper;

    public function __construct(MT5Helper $mT5Helper)
    {
        $this->mT5Helper = $mT5Helper;
    }

    public function main()
    {
        $userId = Auth::user()->id;
        $logins = LiveAccount::where('user_id', $userId)->pluck('login');
        $balances = [];
        foreach ($logins as $login) {
            $result = [];
            // $result = $this->mT5Helper->getAccountInfo($login);
            if($result) {
                $balances[$login]['balance'] = $result->oInfo->Balance;
                $balances[$login]['group'] = $result->oInfo->Group;
            }
        }
        $fromDate = date('Y-m-d', strtotime(date('Y-m-d') . "-30 days"));
        $orders = Order::where('user_id', $userId)
            ->where('status', config('deposit.status.yes'))
            ->whereBetween('created_at', [$fromDate, now()])
            ->get();
        foreach (config('deposit.type') as $type) {
            $orderData[$type] = 0;
        }
        $orderTotal = 0;
        foreach ($orders  as $order) {
            if (is_null($order->usd)) {
                $usd =  round(($order->amount_money) / 23000, 2);
                $orderTotal += $usd;
                $orderData[$order->type] += $usd;
            } else {
                $orderTotal += $order->usd;
                $orderData[$order->type] += $order->usd;
            }
        }
        $withdrawals = WithdrawalFund::where('user_id', $userId)
            ->where('status', config('deposit.status.yes'))
            ->whereBetween('created_at', [$fromDate, now()]);
        $withdrawalTotal = $withdrawals->sum('amount');
        $withdrawals = $withdrawals->groupBy('login')
            ->selectRaw('sum(amount) as total,login')
            ->get();
        return view('home', compact(['balances', 'orderData', 'withdrawals', 'orderTotal', 'withdrawalTotal']));
    }
}
