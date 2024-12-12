@php
    $auth_user = auth()->user();
    use \Illuminate\Support\Str;
@endphp
<div class="side-nav">
    <div class="side-nav-inner">
        @if ($auth_user->hasRole('superadmin'))
            <ul class="side-nav-menu scrollable">
                {{-- <li class="nav-item {{url()->current() == route('backend.dashboard') ? 'active' :''}}">
                <a href="{{route('backend.dashboard')}}">
                    <span class="icon-holder">
                        <i class="fas fa-home"></i>
                    </span>
                    <span class="title">Home</span>
                </a>
            </li> --}}
                <li class="nav-item {{ Str::contains(url()->current(), 'live-tracking') ? 'active' : ''  }}">
                    <a href="{{ route('backend.orders.liveTracking') }}">
                        <span class="icon-holder">
                            <i class="fas fa-route"></i>
                        </span>
                        <span class="title">Live Tracking</span>
                    </a>
                </li>
                <li class="nav-item {{ Str::contains(url()->current(), 'orders') ? 'active' : ''  }}">
                    <a href="{{ route('backend.orders') }}">
                        <span class="icon-holder">
                            <i class="fas fa-clipboard-check"></i>
                        </span>
                        <span class="title">Orders</span>
                    </a>
                </li>
                <li class="nav-item {{ Str::contains(url()->current(), 'tasks') ? 'active' : '' }}">
                    <a href="{{ route('backend.tasks.view') }}">
                        <span class="icon-holder">
                            <i class="fas fa-tasks"></i> </span>
                        <span class="title">Tasks</span>
                    </a>
                </li>
                <li class="nav-item {{ Str::contains(url()->current(), 'proxies') ? 'active' : '' }}">
                    <a href="{{ route('backend.proxy.view') }}">
                        <span class="icon-holder">
                            <i class="fas fa-globe"></i></span>
                        <span class="title">Proxies</span>
                    </a>
                </li>
                <li class="nav-item {{  Str::contains(url()->current(), 'payment_cards') ? 'active' : ''}}">
                    <a href="{{ route('backend.payment_card.view') }}">
                        <span class="icon-holder">
                            <i class="far fa-credit-card"></i></span>
                        <span class="title">Payment Cards</span>
                    </a>
                </li>
                <li class="nav-item {{ url()->current() == route('backend.setting.view') ? 'active' : '' }}">
                    <a href="{{ route('backend.setting.view') }}">
                        <span class="icon-holder">
                            <i class="fas fa-cog"></i> </span>
                        <span class="title">Settings</span>
                    </a>
                </li>
            </ul>
        @endif
    </div>
</div>
