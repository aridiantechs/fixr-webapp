@php
    $auth_user = auth()->user();
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
                <li class="nav-item {{ url()->current() == route('backend.orders.liveTracking') ? 'active' : '' }}">
                    <a href="{{ route('backend.orders.liveTracking') }}">
                        <span class="icon-holder">
                            <i class="fas fa-route"></i>
                        </span>
                        <span class="title">Live Tracking</span>
                    </a>
                </li>
                <li class="nav-item {{ url()->current() == route('backend.orders') ? 'active' : '' }}">
                    <a href="{{ route('backend.orders') }}">
                        <span class="icon-holder">
                            <i class="fas fa-clipboard-check"></i>
                        </span>
                        <span class="title">Orders</span>
                    </a>
                </li>
                <li class="nav-item {{ url()->current() == route('backend.tasks.view') ? 'active' : '' }}">
                    <a href="{{ route('backend.tasks.view') }}">
                        <span class="icon-holder">
                            <i class="fas fa-tasks"></i> </span>
                        <span class="title">Task</span>
                    </a>
                </li>
                <li class="nav-item {{ url()->current() == route('backend.proxy.view') ? 'active' : '' }}">
                    <a href="{{ route('backend.proxy.view') }}">
                        <span class="icon-holder">
                           <i class="fas fa-globe"></i></span>
                        <span class="title">Proxies</span>
                    </a>
                </li>
                <li class="nav-item {{ url()->current() == route('backend.automation.view') ? 'active' : '' }}">
                    <a href="{{ route('backend.automation.view') }}">
                        <span class="icon-holder">
                            <i class="fas fa-robot"></i> </span>
                        <span class="title">Automation</span>
                    </a>
                </li>
                <li class="nav-item {{ url()->current() == route('backend.payment_card.view') ? 'active' : '' }}">
                    <a href="{{ route('backend.payment_card.view') }}">
                        <span class="icon-holder">
                            <i class="far fa-credit-card"></i></span>
                        <span class="title">Payment Cards</span>
                    </a>
                </li>

            </ul>
        @endif
    </div>
</div>
