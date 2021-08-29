@extends('layouts.simplepage')
@section('css')
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
            <li><span>Withdrawal Funds</span></li>
        </ol>
        <a class="sidebar-right-toggle" data-open="sidebar-right"></a>
    </div>
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
        <section class="panel">
            <header class="panel-heading">
                <div class="panel-actions">
                    <a href="#" class="fa fa-caret-down"></a>
                </div>

                <h2 class="panel-title">Xác thực email</h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal form-bordered" method="post" action="{{ route('valid.email.post') }}">
                    @csrf
                    <div class="form-group-inner">
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="form-group col-md-3"></div>
                            <div class="form-group col-md-4">
                                <label><b>Email</b></label>
                                <input type="text" name="email" class="form-control" placeholder="Enter email" value="{{old('email')}}">
                                @if($errors->has('email'))
                                <span class="text-danger text-md-left">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                    </div>
                    <div class="form-group-inner">
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-4"></div>
                            <div class="form-group col-md-5">
                                <button type="submit" class="mb-xs mt-xs mr-xs btn btn-primary">Send</button>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
<input type="hidden" class="level1-toggle" value="bank" />
<input type="hidden" class="level2-toggle" value="withdraw" />
</section>
@endsection
