@extends('layouts.simplepage', ['pageName' => 'Live account', 'parent' => 'Account', 'children' => 'Live'])
@section('css')
<link rel="stylesheet" href="{{ asset('css/magnific-popup.css')}}">
<link rel="stylesheet" href="{{ asset('css/loader.css')}}">
<style>

    .local_bank_image{
        width: 100%;
        margin-bottom: 18px;
    }
    .local_bank_item{
        min-height: 212px;
    }
</style>
@endsection
@include('layouts.menutop')
<header class="page-header">
    <div class="right-wrapper pull-right">
        <ol class="breadcrumbs">
            <li>
                <a href="index.html">
                    <i class="fa fa-home"></i>
                </a>
            </li>
            <li><span>Deposit & Withdrawal</span></li>
            <li><span>Deposit Funds</span></li>
        </ol>
        <a class="sidebar-right-toggle" data-open="sidebar-right"></a>
    </div>
</header>
@section('content')
<div id="loader" class="lds-dual-ring overlay hidden "></div>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <div class="panel-body">
                <h2 style="padding-top : 20px">Local bank</h2>
                <section class="content-with-menu content-with-menu-has-toolbar media-gallery" style="min-height: unset;">
                    <div class="content-with-menu-container">
                        <div class="inner-body mg-main" style="min-height: unset;">
                            <div class="row mg-files" data-sort-destination data-sort-id="media-gallery">
                                <div class="isotope-item document col-sm-6 col-md-4 col-lg-2">
                                    <a href="#exnpay" class="modal-with-form">
                                        <div class="thumbnail">
                                            <div class="thumb-preview text-center">
                                                <img src="{{ asset('image/exnpay.jpg') }}" class="img-thumnail" alt="Project" style="height:110px">
                                                <div class="mg-thumb-options"></div>
                                            </div>
                                        </div>
                                    </a>
                                    <div id="exnpay" class="modal-block modal-block-primary mfp-hide">
                                        <section class="panel">
                                            <div class="panel-body">
                                                <form class="ajax-form" class="form-horizontal" method="post" action="{{ route('transfer.exnpay') }}" novalidate="novalidate">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label"><b>Amount of money
                                                                (VND)</b></label>
                                                        <div class="col-sm-9">
                                                            <input type="number" name="amount_money" class="form-control" placeholder="Amount of money" value="{{ old('amount_money') }}" />
                                                            <div class="errors errors-amount_money"></div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label"><b>Choose account</b></label>
                                                        <div class="col-sm-9">
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
                                                            <div class="errors errors-login"></div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="form-group">
                                                        <div class="col-sm-3"></div>
                                                        <div class="col-sm-9">
                                                            <button type="submit" class="btn btn-primary">Transfer
                                                            </button>
                                                            <button class="btn btn-default modal-dismiss">Cancel
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                                {{-- <div class="isotope-item document col-sm-6 col-md-4 col-lg-2">
                                    <a href="{{ route('deposit.bepay') }}">
                                        <div class="thumbnail">
                                            <div class="thumb-preview" style="">
                                                <img src="{{ asset('image/paynew.jpg') }}" class="img-responsive" alt="Project" style="height: 100%">
                                                <div class="mg-thumb-options"></div>
                                            </div>
                                        </div>
                                    </a>
                                </div> --}}
                                <div class="isotope-item document col-sm-6 col-md-4 col-lg-2 winpay">
                                    <a href="{{ route('deposit.winpay') }}">
                                        <div class="thumbnail">
                                            <div class="thumb-preview" style="">
                                                <img src="{{ asset('image/vifapay.jpg') }}" class="img-responsive" alt="Project" style="padding-top:33px; padding-bottom: 33px;">
                                                <div class="mg-thumb-options"></div>
                                            </div>
                                        </div>
                                    </a>

                                </div>
                                <div class="isotope-item document col-sm-6 col-md-4 col-lg-2 winpay">
                                    <a href="{{ route('deposit.winpay') }}">
                                        <div class="thumbnail">
                                            <div class="thumb-preview text-center" style="margin-top:10px">
                                                <img src="{{ asset('image/asia_pay.png') }}" class="img-thumnail" alt="Project">
                                                <div class="mg-thumb-options"></div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                {{-- <div class="isotope-item document col-sm-6 col-md-4 col-lg-2">
                                    <a href="#tether" class="modal-with-form">
                                        <div class="thumbnail">
                                            <div class="thumb-preview text-center">
                                                <img src="{{ asset('image/tether.png') }}" class="img-thumnail" alt="Project" style="height:110px">
                                                <div class="mg-thumb-options"></div>
                                            </div>
                                        </div>
                                    </a>
                                    <div id="tether" class="modal-block modal-block-primary mfp-hide">
                                        <section class="panel">
                                            <header class="panel-heading">
                                                <h2 class="panel-title">Nạp Tether USDT</h2>
                                            </header>
                                            <div class="panel-body" style="padding-left: 50px;">
                                                <h4 style="font-weight: 700;">
                                                    Định dạng ví
                                                </h4>
                                                <div>
                                                    <ul class="tether_usd">
                                                        <li class="trc checked"><span>TRC20</span><i class="fa fa-check"></i></li>
                                                        <li class="erc"><span>ERC20</span><i class="fa fa-check hidden"></i></li>
                                                    </ul>
                                                </div>
                                                <div class="trc_code">
                                                    <b>Ví USDT</b>
                                                    <p id="trc_code">TAX2oCLQs1bG7sBdRUApuBmTq6aGkZJMR5</p>
                                                    <button type="button" class="btn btn-default copy copy_trc" onclick="copyLink('trc_code')">Copy to clipboard</button>
                                                </div>
                                                <div class="erc_code hidden">
                                                    <b>Vi USDT</b>
                                                    <p id="erc_code">0x2260d99c0385a631ddf463da1d75ea69deb6cb9d</p>
                                                    <button type="button" class="btn btn-default copy copy_erc " onclick="copyLink('erc_code')">Copy to clipboard</button>
                                                </div>
                                                <button class="btn btn-secondary modal-dismiss">Cancel
                                                </button>
                                            </div>

                                        </section>

                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </section>
                <h2>Thanh toán qua P2P</h2>
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-3 col-xs-4 local_bank_item">
                        <img src="{{ asset('image/local_bank.jpg') }}" class="local_bank_image">
                        <b>UNITED KINGDOM BANK</b>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-3 col-xs-4 local_bank_item ">
                        <img src="{{ asset('image/local_bank.jpg') }}" class="local_bank_image">
                        <b class="">EUROPE BANK</b>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-3 col-xs-4 local_bank_item">
                        <img src="{{ asset('image/local_bank.jpg') }}" class="local_bank_image">
                        <b class="">SINGAPORE BANK</b>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-3 col-xs-4 local_bank_item">
                        <img src="{{ asset('image/local_bank.jpg') }}" class="local_bank_image">
                        <b class=""> AUSTRALIA BANK</b>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-3 col-xs-4 local_bank_item">
                        <img src="{{ asset('image/local_bank.jpg') }}" class="local_bank_image">
                        <b class="">HONGKONG BANK</b>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-3 col-xs-4 local_bank_item">
                        <img src="{{ asset('image/local_bank.jpg') }}" class="local_bank_image">
                        <b class="">JAPAN BANK</b>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<input type="hidden" class="level1-toggle" value="bank" />
<input type="hidden" class="level2-toggle" value="deposit" />
</section>
@endsection
@section('js')
<script src="{{ asset('js/magnific-popup.js') }}"></script>
<script src="{{ asset('js/examples.modals.js') }}"></script>
<script src="{{ asset('js/form.js') }}"></script>
<script>
    $('.trc').on('click', function() {
        $('.trc').addClass('checked')
        $('.erc').removeClass('checked')
        $('.trc_code').removeClass('hidden')
        $('.trc .fa-check').removeClass('hidden')
        $('.erc_code').addClass('hidden')
        $('.erc .fa-check').addClass('hidden')

    })
    $('.erc').on('click', function() {
        $('.erc').addClass('checked')
        $('.trc').removeClass('checked')
        $('.trc_code').addClass('hidden')
        $('.erc_code').removeClass('hidden')
        $('.erc .fa-check').removeClass('hidden')
        $('.trc .fa-check').addClass('hidden')

    })

    function copyLink(id) {
        var from = document.getElementById(id);
        var range = document.createRange();
        window.getSelection().removeAllRanges();
        range.selectNode(from);
        window.getSelection().addRange(range);
        document.execCommand('copy');
        window.getSelection().removeAllRanges();
    }
</script>
@endsection
