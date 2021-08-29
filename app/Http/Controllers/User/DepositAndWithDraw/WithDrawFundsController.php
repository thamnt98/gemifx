<?php

namespace App\Http\Controllers\User\DepositAndWithDraw;

use App\Http\Controllers\Controller;
use App\Models\LiveAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ValidateEmailRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\ValidateEmail;
use App\Http\Requests\ValidateOtpRequest;
use Illuminate\Support\Facades\Session;

class WithDrawFundsController extends Controller
{
    public function main()
    {
        $logins = LiveAccount::where('user_id', Auth::user()->id)->pluck('login');
        return view('withdrawanddeposit.withdraw_funds', compact('logins'));
    }

    public function validateEmail(Request $request)
    {
        return view('withdrawanddeposit.valid_email');
    }
    public function validateEmailPost(ValidateEmailRequest $validateEmailRequest)
    {
        $data = $validateEmailRequest->all();
        $auth = Auth::user();
        if($data['email'] != $auth->email){
            return redirect()->back()->with('error','Email không phải là tài khoản đăng ký');
        }
        $otp = $otp = rand(100000, 999999);
        session(['otp_send' => $otp]);
        session(['view_otp' => true]);
        Mail::to($data['email'])->send(new ValidateEmail($otp));
        return redirect()->route('valid.otp');
    }

    public function validateOtp()
    {
        return view('withdrawanddeposit.otp');
    }

    public function validateOtpPost(ValidateOtpRequest $validateOtpRequest)
    {
        $data = $validateOtpRequest->all();
        $user = Auth::user();
        $otp_session = session('otp_send');
        if($otp_session == $data['otp']){
            session(['check_success' => true]);
            session(['email_check' => $user->email]);
            Session::forget('view_otp');
            return redirect()->route('withdraw.funds');
        }
        return redirect()->back()->with('error','Mã Otp không hợp lệ');
    }
}
