<?php

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('logout', function() {
    Auth::logout();
    return redirect('/login');
});
Auth::routes();
Route::get('', 'User\HomeController@main')->middleware('auth')->name('home');
Route::get('/register', 'Auth\CreateController@main')->name('register');
Route::post('/register', 'Auth\RegisterController@main')->name('register');
Route::get('/password/reset', 'ResetPasswordController@main')->name('password.reset');
Route::post('/password/reset', 'UpdatePasswordController@main')->name('password.update');
Route::get('/password/forgot', 'ForgotPasswordController@main')->name('password.forgot');
Route::post('/password/forgot', 'SendEmailForgotPasswordController@main')->name('password.email');
Route::group([
    'namespace' => 'User',
    'middleware' => 'auth',
    'prefix' => 'trader'
], function () {
    Route::get('/support', 'SupportController@main')->name('support');
    Route::group([
        'namespace' => 'Account'
    ], function () {
        Route::post('/open-trading-account', 'LiveAccountController@main')->name('account.live');
        Route::get('/open-trading-account', 'LiveAccountController@main');

        Route::post('/open-ib-account', 'OpenIBAccountController@main')->name('account.ib.open');
        Route::get('/change-mt-password', 'MTPasswordController@main')->name('account.MTPassword');
        Route::post('/change-mt-password', 'ChangeMTPasswordController@main')->name('account.MTPassword.change');
        Route::get('/my-profile', 'DetailController@main')->name('account.detail');
        Route::post('/my-profile', 'UpdateController@main')->name('account.update');
        Route::post('/my-profile/upload', 'UploadFileController@main')->name('account.upload');
        Route::post('/my-profile/password', 'ChangePasswordController@main')->name('account.password.change');
        Route::get('/{login}/balance', 'GetBalanceByLoginController@main');
        Route::get('/send/otp', 'SendOTPController@main')->name('send.otp');
    });
    Route::group([
        'namespace' => 'DepositAndWithDraw'
    ], function () {
        Route::get('/deposit-funds', 'DepositFundsController@main')->name('deposit.funds');
        Route::get('/withdrawal-funds', 'WithDrawFundsController@main')->name('withdraw.funds')->middleware('valid.email');
        Route::post('/withdrawal-funds', 'CreateWithdrawalFundsController@main')->name('withdraw.funds.create')->middleware('valid.email');
        Route::get('/bepay', 'GetFormBepayController@main')->name('deposit.bepay');
        Route::post('/bepay', 'BepayTransferController@main')->name('deposit.bepay.transfer');
        Route::post('/transfer/vifa', 'TransferByVifaController@main')->name('transfer.vifa');
        Route::post('/transfer/exnpay', 'ExnpayController@main')->name('transfer.exnpay');
        Route::get('/winpay', 'GetFormWinpayController@main')->name('deposit.winpay');
        Route::post('/winpay', 'WinpayTransferController@main')->name('deposit.winpay.transfer');
        Route::get('/valid/email', 'WithDrawFundsController@validateEmail')->name('valid.email.withdrawal');
        Route::post('/validate/email', 'WithDrawFundsController@validateEmailPost')->name('valid.email.post');
        Route::get('/valid/otp', 'WithDrawFundsController@validateOtp')->name('valid.otp')->middleware('valid.otp');
        Route::post('/valid/otp', 'WithDrawFundsController@validateOtpPost')->name('valid.otp.post');
    });
    Route::group([
        'namespace' => 'Trading'
    ], function () {
        Route::get('/trading/history', 'TradingHistoryController@main')->name('trading.history');
    });
});
