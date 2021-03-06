@extends('layouts.simplepage', ['pageName' => 'Live account', 'parent' => 'Account', 'children' => 'Live'])
@section('css')
<link rel="stylesheet" href="{{ asset('css/magnific-popup.css')}}">
<link rel="stylesheet" href="{{ asset('css/deposit.css')}}">
@endsection
<header class="page-header">
    @include('layouts.menutop')
</header>
@section('content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <div class="panel-body">
                <form class="form-horizontal" method="post" action="{{ route('deposit.bepay.transfer') }}"
                    novalidate="novalidate">
                    @csrf
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
                                            @foreach ($listAccounts as $account)
                                                @if (old('login') == $account)
                                                    <option value="{{$account}}" selected>{{$account}}</option>
                                                @else
                                                    <option value="{{$account}}">{{$account}}</option>
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
                                    <label class="control-label"><b>Chọn ngân hàng</b></label>
                                    @if($errors->has('bank'))
                                        <br>
                                        <span class="text-danger text-md-left font-weight-bold" >{{ $errors->first('bank') }}</span>
                                    @endif
                                    <div class="row" style="margin-top: 20px">
                                        @foreach ($banks as $bank)
                                        <div class="col-lg-3">
                                            <input type="radio" name="bank" value="{{ $bank->code . '-' . $bank->bank_name }}" id="{{ $bank->code }}">
                                            <label for="{{ $bank->code }}">
                                                <img src="{{ $bank->bank_logo }}" class="img-thumbnail"
                                                style="height: 100px;margin-bottom:20px">
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-lg-1"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-10 text-center">
                                <button type="submit" class="btn btn-primary open-form-transfer">Chuyển khoản qua internet banking</button>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="form-transfer hidden">
                        <section class="panel form-wizard" id="w4">
                            <header class="panel-heading">
                                <h2 class="panel-title">Thời gian còn lại </h2>
                            </header>
                            <div class="panel-body">
                                <div class="wizard-progress wizard-progress-lg">
                                    <div class="steps-progress">
                                        <div class="progress-indicator"></div>
                                    </div>
                                    <ul class="wizard-steps">
                                        <li class="active">
                                            <a href="#signin" data-toggle="tab"><span>1</span>Đăng nhập </a>
                                        </li>
                                        <li>
                                            <a href="#verify" data-toggle="tab"><span>2</span>Xác thực giao dịch </a>
                                        </li>
                                        <li>
                                            <a href="#result" data-toggle="tab"><span>3</span>Kết quả</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-content">
                                    <div id="signin" class="tab-pane active">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-1"></div>
                                                <div class="col-lg-10">
                                                    <label class="col-sm-3 control-label"><b>Tên đăng nhập tài khoản Internet Banking</b></label>
                                                    <input class="form-control">
                                                </div>
                                                <div class="col-lg-1"></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-1"></div>
                                                <div class="col-lg-10">
                                                    <label class="col-sm-3 control-label"><b>Mật khẩu Internet Banking</b></label>
                                                    <input class="form-control">
                                                </div>
                                                <div class="col-lg-1"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="verify" class="tab-pane">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-1"></div>
                                                <div class="col-lg-10">
                                                    <label class="col-sm-3 control-label"><b>Nhập mã OTP</b></label>
                                                    <input class="form-control">
                                                </div>
                                                <div class="col-lg-1"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="result" class="tab-pane">
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <ul class="pager">
                                    <li class="previous disabled">
                                        <a><i class="fa fa-angle-left"></i> Previous</a>
                                    </li>
                                    <li class="finish hidden pull-right">
                                        <a>Finish</a>
                                    </li>
                                    <li class="next">
                                        <a>Next <i class="fa fa-angle-right"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </section>
                    </div> --}}
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
{{-- <script src="{{ asset('js/jquery.bootstrap.wizard.js') }}"></script>
<script src="{{ asset('js/jquery.validate.js') }}"></script>
<script src="{{ asset('js/examples.wizard.js') }}"></script> --}}
{{-- <script src="{{ asset('js/form.js') }}"></script> --}}
{{-- <script>
    $(document).ready(function () {
        $('.open-form-transfer').on('click', function () {
            $('.form-transfer').toggleClass('hidden');
            $('.general').toggleClass('hidden');
        })
    })
</script> --}}
{{-- <script>
    $(document).ready(function() {
  $(".img-thumbnail").on('click', function() {
    $(".img-thumbnail").each(function() {
      $(this).css({
        "drop-shadow": "none"
      });
    })
    $(this).css({
      "drop-shadow": "1px 2px 4px black"
    });
  });
}); --}}
</script>
@endsection
