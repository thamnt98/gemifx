<?php

namespace App\Http\Controllers\User\Account;

use App\Http\Controllers\Controller;
use App\Models\LiveAccount;
use Illuminate\Support\Facades\Auth;
use App\Helper\MT5Helper;

class MTPasswordController extends Controller
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
        return redirect()->route('home');
        $logins = LiveAccount::where('user_id', Auth::user()->id)->pluck('login');
        $data = [];
        if (count($logins)) {
            try {
                foreach ($logins as $login) {
                    $result = $this->mT5Helper->getAccountInfo($login);
                    $data[$login]['balance'] = $result->oInfo->Balance;
                    $data[$login]['group'] = $result->oInfo->Group;
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', "Something went wrong. Please try again");
            }
        }
        return view('account.changepassword', compact('data'));
    }
}
