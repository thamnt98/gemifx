<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\UserRegisteredSuccess;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Create a new user instance after a valid registration.
     * @param array $data
     * @return \App\User
     */
    protected function main(Request $request)
    {
        $data = $request->all();
        $validate = $this->validator($data);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }
        try {
            DB::beginTransaction();
            $data['password'] = Hash::make(Str::random(8));
            $user = User::create($data);
            $email = $user->email;
            $token = $this->createToken($email);
            Mail::to($email)->send(new UserRegisteredSuccess($user, $token));
            DB::commit();
            return back()->with(
                'success',
                "We have sent you an email to setting password. Please check your inbox or spam"
            );
        } catch (\Exception $e) {
            Log::channel('mail')->info($e->getTraceAsString());
            DB::rollBack();
            return back()->with('error', "Something went wrong");
        }
    }

    /**
     * Get a validator for an incoming registration request.
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make(
            $data,
            [
                'first_name'   => ['required', 'string', 'max:255'],
                'last_name'    => ['required', 'string', 'max:255'],
                'phone_number' => 'required|unique:users|regex:/^\+\d{9,12}$/',
                'email'        => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'ib_id'        => 'nullable|regex:/[0-9]{6}/',
            ],
            [
                'ib_id.regex' => 'The IB ID has only 6 digits',
                'phone_number.regex' => "The phone number must  include phone country code"
            ]
        );
    }

    private function createToken($email)
    {
        $key = config('app.key');
        if (Str::startsWith($key, 'base64:')) {
            $key = base64_decode(substr($key, 7));
        }
        $token = hash_hmac('sha256', Str::random(40), $key);
        PasswordReset::updateOrCreate(
            ['email' => $email],
            [
                'token'      => $token,
                'email'      => $email,
                'created_at' => Carbon::now(),
            ]
        );
        return $token;
    }
}
