@extends('layouts.simplepage', ['pageName' => 'Live account', 'parent' => 'Account', 'children' => 'Live'])
@section('css')
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{ asset('css/deposit.css')}}">
@endsection
<style>
    .fa.fa-copy{
        float: right;
        margin-top: -25px;
        margin-right: 10px;
    }

</style>
<header class="page-header">
    @include('layouts.menutop')
</header>
@section('content')
    <div class="row">
        <div class="col-lg-12">
            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-block" style="margin: 0px 15px 20px 15px">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block" style="margin: 0px 15px 20px 15px">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            <section class="panel">
                <div class="panel-body">
                    <form class="form-horizontal" method="post" action="{{ route('deposit.winpay.transfer') }}"
                          novalidate="novalidate">
                        @csrf
                        <input type="hidden" name="user_code" value="{{ $bankInfo->user_code }}">
                        <input type="hidden" name="user_name" value="{{ $bankInfo->user_name }}">
                        <input type="hidden" name="bank_code" value="{{ $bankInfo->bank_code }}">
                        <input type="hidden" name="expire_time" value="{{ date('Y-m-d H:i:s') }}">
                        <input type="hidden" name="order_number" value="{{ $code }}">
                        <div class="bepay">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-1"></div>
                                    <div class="col-lg-10">
                                        <label class="control-label"><b>Số tiền nạp (VND)</b></label>
                                        <input class="form-control" name="amount_money" value="{{ old('amount_money') }}">
                                        @if($errors->has('amount_money'))
                                            <span class="text-danger text-md-left font-weight-bold" >{{ $errors->first('amount_money') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-lg-1"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-1"></div>
                                    <div class="col-lg-10">
                                        <div class="choose_account">
                                            <label class="control-label"><b>Chọn tài khoản</b></label>
                                            <select name="login" id="" class="form-control">
                                                <option value="">Choose account</option>
                                                @foreach ($logins as $login)
                                                    @if (old('login') == $login)
                                                        <option value="{{$login}}" selected>{{$login}}</option>
                                                    @else
                                                        <option value="{{$login}}">{{$login}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @if ($errors->has('login'))
                                                <span
                                                    class="text-danger text-md-left font-weight-bold">{{ $errors->first('login') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-1"></div>
                                    <div class="col-lg-10">
                                        <b>Số lệnh</b>
                                        <input type="text" style="color: red " class="form-control order-number" id="order_number" readonly value="{{ $code }}" ><i class="fa fa-copy" onclick="copyLink('order_number')"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-1"></div>
                                    <div class="col-lg-10">
                                        <b>Tên ngân hàng </b>
                                        <input type="text" style="color: red " class="form-control " id="bank_code" readonly value="{{ $bankInfo->bank_code }}"><i class="fa fa-copy" onclick="copyLink('bank_code')"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-1"></div>
                                    <div class="col-lg-10">
                                        <b>Số tài khoản </b>
                                        <input type="text" style="color: red " class="form-control " id="user_code" readonly value="{{ $bankInfo->user_code }}">
                                        <i class="fa fa-copy" onclick="copyLink('user_code')"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-1"></div>
                                    <div class="col-lg-10">
                                        <b>Tên người nhận </b>
                                        <input type="text" style="color: red " class="form-control" readonly value="{{ $bankInfo->user_name }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-1"></div>
                                <div class="col-sm-10">
                                    <b>Mô tả giao dịch : </b>
                                    <i>Nội dung chuyển khoản phải  ghi mã số lệnh, có thể kèm theo tên chính chủ của bạn</i>
                                    <br>
                                    <br>
                                    <b style="font-size: 12px;">Lưu ý: Thông tin giao dịch và mã lệnh chỉ có hiệu lực trong vòng <span style="color: red">15 </span> phút</b>
                                    <br>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-1"></div>
                                <div class="col-sm-10 text-center">
                                    <button type="submit" class="btn btn-primary open-form-transfer">Xác nhận chuyển khoản</button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
    <input type="hidden" class="level1-toggle" value="bank" />
    <input type="hidden" class="level2-toggle" value="deposit" />
    </section>
    @endsection
    @section('js')
        <script>
            function copyLink(id) {
                var copyText = document.getElementById(id);

                /* Select the text field */
                copyText.select();
                copyText.setSelectionRange(0, 99999); /* For mobile devices */

                /* Copy the text inside the text field */
                document.execCommand("copy");
            }
    </script>
@endsection
