	<!-- start: sidebar -->
    <?php
    $liveAccounts = \App\Models\LiveAccount::where('user_id', Auth::user()->id)->get();
    ?>
    <aside id="sidebar-left" class="sidebar-left">
        <div class="sidebar-header">
            <div class="sidebar-title">
                <img src="{{ asset('image/icon_offline_0.jpeg') }}">
            </div>
            <div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
                <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
            </div>
        </div>

        <div class="nano">
            <div class="nano-content">
                <nav id="menu" class="nav-main" role="navigation">
                    <ul class="nav nav-main">
                        <li class="level-1" data-toggle="dashboard">
                            <a href="{{ route('home') }}">
                                <i class="fa fa-home" aria-hidden="true"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-parent level-1" data-toggle="account">
                            <a>
                                <i class="fa fa-play-circle-o " aria-hidden="true"></i>
                                <span>Open Accounts</span>
                            </a>
                            <ul class="nav nav-children">
                                <li class="level-2" data-toggle="live">
                                    <a href="@if(count($liveAccounts) <2) {{ route('send.otp') }} @else {{ route('account.live') }} @endif">
                                        Live Account
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-parent level-1" data-toggle="bank">
                            <a>
                                <i class="fa fa-bank" aria-hidden="true"></i>
                                <span>Deposit & Withdrawal</span>
                            </a>
                            <ul class="nav nav-children">
                                <li class="level-2" data-toggle="deposit">
                                    <a href="{{ route('deposit.funds') }}">
                                         Deposit Funds
                                    </a>
                                </li>
                                <li class="level-2" data-toggle="withdraw">
                                    <a href="{{ route('withdraw.funds') }}">
                                         Withdrawal Funds
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="level-1" data-toggle="trading">
                            <a href="{{  route('trading.history') }}">
                                <i class="fa fa-history" aria-hidden="true"></i>
                                <span>History</span>
                            </a>
                        </li>
                        <li class="level-1" data-toggle="partnership">
                            <a href="https://ibgemi.com/register">
                                <i class="fa fa-users" aria-hidden="true"></i>
                                <span>IB Partnership</span>
                            </a>
                        </li>
                        <li class="level-1" data-toggle="password">
                            <a href="{{ route('account.MTPassword') }}">
                                <i class="fa fa-users" aria-hidden="true"></i>
                                <span>Change MT Passworrd</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </aside>
    <!-- end: sidebar -->
