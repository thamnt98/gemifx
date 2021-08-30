@extends('layouts.simplepage')
@section('css')
<link rel="stylesheet" href="{{ asset('css/intlTelInput.css') }}">
<link rel="stylesheet" href="{{ asset('css/bootstrap-table.css') }}" />
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
            <li><span>Your profile</span></li>
        </ol>
        <a class="sidebar-right-toggle" data-open="sidebar-right"></a>
    </div>
</header>
@section('content')
<div class="row">
    @if($user->check_active == 1)
    <div class="col-lg-12" style="margin-bottom: 10px">
        <h3 style="color: #1da21b">Tài khoản của bạn đã được xác thực</h3>
    </div>
    @endif
    <div class="col-lg-12">
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block" style="margin: 0px 15px 20px 15px">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif
        @if ($message = Session::get('warning'))
        <div class="alert alert-warning alert-block" style="margin: 0px 15px 20px 15px">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
        @endif
        <section class="panel">
            <header class="panel-heading">
                <div class="panel-actions">
                    <a href="#" class="fa fa-caret-down"></a>
                </div>

                <h2 class="panel-title"><b>Edit your info</b></h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal form-bordered" method="post"  action="{{route('account.update')}}">
                    {{ csrf_field() }}
                    <div class="form-group-inner">
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <label><b>First Name</b></label>
                            <input type="text" class="form-control" name="first_name" value="{{ old('first_name', $user->first_name) }}">
                            </div>
                            <div class="form-group col-md-5">
                                <label><b>City</b></label>
                                <input type="text" class="form-control"  name="city" value="{{ old('city', $user->city) }}">
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                    </div>
                    <div class="form-group-inner">
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <label><b>Last Name</b></label>
                                <input type="text" class="form-control"  name="last_name" value="{{ old('last_name', $user->last_name) }}">
                            </div>
                            <div class="form-group col-md-5">
                                <label><b>Zip Code</b></label>
                                <input type="text" class="form-control"  name="zip_code" value="{{ old('zip_code', $user->zip_code) }}">
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                    </div>
                    <div class="form-group-inner">
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <label><b>Phone</b></label>
                                <input id="phone" name="phone_number" type="text" class="form-control" value="{{ old('phone_number', $user->phone_number) }}" placeholder="+19172678536">
                                @if($errors->has('phone_number'))
                                    <span class="text-danger text-md-left" >{{ $errors->first('phone_number') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-5">
                                <label><b>State</b></label>
                                <input type="text" class="form-control" name="state" value="{{ old('state', $user->state) }}">
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                    </div>
                    <div class="form-group-inner">
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <label><b>Address</b></label>
                            <input type="text" class="form-control" name="address" value="{{ old('address', $user->address) }}">
                            </div>
                            <div class="form-group col-md-5">
                                <label><b>Country</b></label>
                                <select name="country" id="country"  class="form-control" name="country" >
                                    @foreach(config('country') as $key=> $country)
                                        @if(old('country') == $key || $user->country == $key)
                                            <option value="{{$key}}" selected>{{$country}}</option>
                                        @else
                                            <option value="{{$key}}">{{$country}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                    </div>
                    <div class="form-group-inner">
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <button type="submit" class="mb-xs mt-xs mr-xs btn btn-primary">Save changes</button>
                                <button type="reset" class="mb-xs mt-xs mr-xs btn btn-default">Cancel</button>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
        <section class="cpanel">
            <header class="panel-heading">
                <h2 class="panel-title"><b>Documents</b></h2>
            </header>
            <div class="panel-body">
            <form class="form-horizontal form-bordered" method="post" action="{{route('account.upload')}}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="table-responsive">
                        <table id="table" data-toggle="table" data-resizable="true" style="font-size: 14px">
                            <thead>
                                <tr>
                                    <th>File Type</th>
                                    <th>View</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><b>Copy Of Id</b></td>
                                    <td>@if($user->copy_of_id)<img src="{{$user->copy_of_id}}" style="height:100px">@endif</td>
                                    <td>
                                        <input  type="file" name="copy_of_id" id="copy-of-id">
                                        <input type="hidden" name="copy_of_id_value" value="{{old('copy_of_id', $user->copy_of_id)}}" id="copy-of-id-value">
                                        @if($errors->has('copy_of_id'))
                                            <span class="text-danger text-md-left" >{{ $errors->first('copy_of_id') }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Proof Of Address</b></td>
                                    <td>@if($user->proof_of_address)<img src="{{$user->proof_of_address}}" style="height:100px">@endif</td>
                                    <td>
                                        <input type="file" name="proof_of_address">
                                        @if($errors->has('proof_of_address'))
                                            <span class="text-danger text-md-left" >{{ $errors->first('proof_of_address') }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>New Additional File</b></td>
                                    <td>@if($user->addtional_file)<img src="{{$user->addtional_file}}" style="height:100px">@endif</td>
                                    <td>
                                        <input  type="file" name="addtional_file">
                                        @if($errors->has('addtional_file'))
                                            <span class="text-danger text-md-left" >{{ $errors->first('addtional_file') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <button type="submit" class="mb-xs mt-xs mr-xs btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </section>
        <section class="panel">
            <header class="panel-heading">
                <div class="panel-actions">
                    <a href="#" class="fa fa-caret-down"></a>
                </div>
                <h2 class="panel-title"><b>Change Your Password</b></h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal form-bordered" method="post" action="{{ route('account.password.change') }}">
                    @csrf
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputSuccess"><b>Current Password</b></label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" name="current_password" value="{{ old('current_password') }}">
                            @if($errors->has('current_password'))
                                <span class="text-danger text-md-left" >{{ $errors->first('current_password') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputSuccess"><b>New Password</b></label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" name="new_password" value="{{ old('new_password') }}">
                            @if($errors->has('new_password'))
                                <span class="text-danger text-md-left" >{{ $errors->first('new_password') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputSuccess"><b>Confirm Password</b></label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}">
                            @if($errors->has('password_confirmation'))
                                <span class="text-danger text-md-left" >{{ $errors->first('password_confirmation') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <button type="submit" class="mb-xs mt-xs mr-xs btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
<div class="footer" style="margin-top:30px; width: 100%;">
    <p style="font-size:11px">Risk Warning Note: Forex and CFDs are leveraged products, incur a high level of risk and may not be suitable for all investors. You should not risk more than you are prepared to lose. Before deciding to trade, please ensure you understand the risks involved and take into account your level of experience. Seek independent advice if necessary.
        © 2020 Copyright GemiFx Inc. 2010-2020 All rights reserved. Various trademarks held by their respective owners. One Financial Center, Suite 1000, Boston, MA, 02111, United States
        <input type="hidden" class="level1-toggle" value="account"/></p>
</div>
</section>
@endsection
@section('js')
<script src="{{ asset('js/bootstrap-table.js') }}"></script>
<script src="{{ asset('js/data-table-active.js') }}"></script>
@endsection
