<?php

namespace App\Http\Controllers\User\Account;

use App\Helper\MT5Helper;
use App\Http\Controllers\Controller;
use App\Models\LiveAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LiveAccountController extends Controller
{
    /**
     * @var mT5Helper
     */
    private $mT5Helper;

    public function __construct(MT5Helper $mT5Helper)
    {
        $this->mT5Helper = $mT5Helper;
    }

    public function main(Request $request)
    {
        return redirect()->route('home');
        $liveAccounts = LiveAccount::where('user_id', Auth::user()->id)->get();
        $phone = $request->mobile_no;
        $ibId = Auth::user()->ib_id;
        $groups = $this->mT5Helper->getGroups();
        $firstGroup = '';
        if($groups){
            $firstGroup = $groups[0];
        }
        return view('account.live', compact('liveAccounts', 'phone', 'ibId', 'firstGroup'));
    }
}
