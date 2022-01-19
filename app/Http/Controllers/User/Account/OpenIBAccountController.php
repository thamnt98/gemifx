<?php

namespace App\Http\Controllers\User\Account;

use App\Http\Controllers\Controller;
use App\Mail\OpenLiveAccountSuccess;
use App\Models\LiveAccount;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Helper\MT5Helper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OpenIBAccountController extends Controller
{

    /**
     * @var mT5Helper
     */
    private $mT5Helper;

    private $logger;

    public function __construct(MT5Helper $mT5Helper, Log $logger)
    {
        $this->mT5Helper = $mT5Helper;
        $this->logger = $logger;
    }


    public function main(Request $request)
    {
        $data = $request->except('_token');
        $phone = $request->phone;
        if (is_null($phone)) {
            return redirect()->route('send.otp');
        }
        $isValid = $this->isValid($data);
        if ($isValid->fails()) {
            return redirect()->back()->withErrors($isValid->errors())->withInput();
        }
        $user = Auth::user();
        $liveAccounts = LiveAccount::where('user_id', $user->id)->get();
        if (count($liveAccounts) >= 2) {
            return redirect()->back()->with(
                'error',
                "You opened two accounts and cant open anymore"
            );
        }
        $params = [
            "Account" => 0,
            "ManagerIndex" => 101,
            "Agent" => $data['ib_id'],
            "First" =>  $user->first_name,
            "Last" => $user->last_name,
            "Group" => $data['group'],
            "Email" => $user->email,
            "Phone" => $phone[1] . $phone[2] . 'xxxxxx' . substr($phone, -4),
            "Leverage" =>   $data['leverage'],
            "Country" =>  $user->country,
            'State' => $user->state,
            'City' => $user->city,
            'ZipCode' => $user->zip_code,
            'Address' => $user->address
        ];
        DB::beginTransaction();
        try {
            $result = $this->mT5Helper->openAccount($params);
            if ($result['ERR_MSG'] != null) {
                return redirect()->back()->with('error', "Can\'t open MT5 Account. Please try again later");
            }
            $this->logger->info('Result open account: ', ['result' => $result]);
            $data['login'] = $result['Account'];
            $data['user_id'] = $user->id;
            $data['phone_number'] = substr($phone, 1);
            $account = LiveAccount::create($data);
            $this->logger->info('Login after save live account: ', ['account' => $account]);
            DB::commit();
            Mail::to($user->email)->send(new OpenLiveAccountSuccess($user, $account, $result['Pwd_Master']));
            return redirect()->back()->with(
                'success',
                "Open live account successfully. Please check your inbox or spam to login into MetaTrader 5"
            );
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', "Something went wrong. Please try again");
        }
    }

    public function isValid($data)
    {
        return Validator::make(
            $data,
            [
                'group'    => 'required',
                'leverage' => 'required',
                'ib_id'    => 'required|regex:/[0-9]{6}/',
            ],
            [
                'ib_id.regex' => 'The IB ID has only 6 digits',
            ]
        );
    }

    public function validatePhone($phone)
    {
        return Validator::make(
            ['phone' => $phone],
            [
                'phone' => 'required|regex:/[0-9]{8}/',
            ]
        );
    }

    public function verifyOTP($otp)
    {
        return Validator::make(
            ['otp' => $otp],
            [
                'otp' => 'required',
            ]
        );
    }
}
