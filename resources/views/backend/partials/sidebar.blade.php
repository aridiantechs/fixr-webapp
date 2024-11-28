@php
    $auth_user=auth()->user();
@endphp
<div class="side-nav">
    <div class="side-nav-inner">
        @if($auth_user->hasRole('superadmin') )
        <ul class="side-nav-menu scrollable">
            {{-- <li class="nav-item {{url()->current() == route('backend.dashboard') ? 'active' :''}}">
                <a href="{{route('backend.dashboard')}}">
                    <span class="icon-holder">
                        <i class="fas fa-home"></i>
                    </span>
                    <span class="title">Home</span>
                </a>
            </li> --}}
            <li class="nav-item {{url()->current() == route('backend.orders.liveTracking') ? 'active' :''}}">
                <a href="{{route('backend.orders.liveTracking')}}">
                    <span class="icon-holder">
                        <i class="fas fa-route"></i>
                    </span>
                    <span class="title">Live Tracking</span>
                </a>
            </li>
            <li class="nav-item {{url()->current() == route('backend.orders') ? 'active' :''}}">
                <a href="{{route('backend.orders')}}">
                    <span class="icon-holder">
                        <i class="fas fa-clipboard-check"></i>
                    </span>
                    <span class="title">Orders</span>
                </a>
            </li>

        </ul>
        @endif
    </div>
</div>
