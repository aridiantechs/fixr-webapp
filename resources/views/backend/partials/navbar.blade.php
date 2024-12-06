<div class="header">
    <div class="logo logo-dark">
        <a href="{{route('/')}}" style="margin: 0;
        position: absolute;
        top: 50%;
        -ms-transform: translateY(-50%);
        transform: translateY(-50%);
        width: inherit">
            {{-- <h1 class="logo-unfold"><span class="text-color1">Cont</span><span class="text-color2"> Man</span></h1> --}}
            {{-- <img src="{{asset('backend/assets/images/fixr-logo.jpg')}}" alt="Logo"> --}}
            <svg class="sc-e251f6e9-2 fNXbIw" xmlns="http://www.w3.org/2000/svg" style="width:70%" viewBox="0 0 435 138"><g clip-path="url(#:R1b9rmH1:)" fill-rule="evenodd" clip-rule="evenodd"><path d="M405.825 92.722c16.275-8.108 25.206-23.33 25.206-44.485 0-30.842-21.038-48.24-57.754-48.24H341.39l-30.234 42.6v95.4h35.33V99.049h27.787l20.641 38.948h40.09l-29.179-45.276Zm-32.548-20.958h-26.793V27.677h26.791c15.282 0 24.213 7.314 24.213 21.747.002 14.633-8.929 22.343-24.213 22.343l.002-.003ZM35.329 138H0V0h103.005v27.285H35.327v32.032H97.65v27.675h-62.32V138Zm175.198-69 20.472-28.843L259.5 0h40.941L251.47 68.996l-20.471 28.842-28.501 40.157h-40.942l48.971-68.996Zm-8.029-69 8.026 11.31-20.47 28.844L161.556 0h40.942Zm48.973 126.69 8.027 11.309h40.941l-28.497-40.152-20.471 28.843Zm-95.532-38.465L120.61 138V0h35.329v88.225Z"></path><path d="M405.825 92.722c16.275-8.108 25.206-23.33 25.206-44.485 0-30.842-21.038-48.24-57.754-48.24H341.39l-30.234 42.6v95.4h35.33V99.049h27.787l20.641 38.948h40.09l-29.179-45.276Zm-32.548-20.958h-26.793V27.677h26.791c15.282 0 24.213 7.314 24.213 21.747.002 14.633-8.929 22.343-24.213 22.343l.002-.003ZM35.329 138H0V0h103.005v27.285H35.327v32.032H97.65v27.675h-62.32V138Zm175.198-69 20.472-28.843L259.5 0h40.941L251.47 68.996l-20.471 28.842-28.501 40.157h-40.942l48.971-68.996Zm-8.029-69 8.026 11.31-20.47 28.844L161.556 0h40.942Zm48.973 126.69 8.027 11.309h40.941l-28.497-40.152-20.471 28.843Zm-95.532-38.465L120.61 138V0h35.329v88.225Z" fill="url(#:R1b9rm:)"></path></g><defs><linearGradient id=":R1b9rm:" x1="-1.61" y1="147.67" x2="433.181" y2="157.816" gradientUnits="userSpaceOnUse"><stop offset=".123" stop-color="#CC013E"></stop><stop offset="1" stop-color="#FF2000"></stop></linearGradient><clipPath id=":R1b9rmH1:"><path fill="#fff" d="M0 0h435v138H0z"></path></clipPath></defs></svg>
        </a>
    </div>
    <div class="logo logo-white">
        <a href="index.html" style="margin: 0;
        position: absolute;
        top: 50%;
        -ms-transform: translateY(-50%);
        transform: translateY(-50%);
        width: inherit">
            <h1><span class="text-color1">C</span><span class="text-color2"> M</span></h1>
        </a>
    </div>
    <div class="nav-wrap">
        <ul class="nav-left">
            <li class="desktop-toggle">
                <a href="javascript:void(0);">
                    <i class="anticon"></i>
                </a>
            </li>
            <li class="mobile-toggle">
                <a href="javascript:void(0);">
                    <i class="anticon"></i>
                </a>
            </li>
        </ul>
        <ul class="nav-right">
            <li class="dropdown dropdown-animated scale-left">
                <div class="pointer" data-toggle="dropdown">
                    <div class="avatar avatar-image  m-h-10 m-r-15">
                        {{-- <img src="{{asset('backend/assets/images/avatars/user.jpg')}}" alt=""> --}}
                        <i class="fa fa-user text-primary"></i>
                    </div>
                </div>
                <div class="p-b-15 p-t-20 dropdown-menu pop-profile">
                    <div class="p-h-20 p-b-15 m-b-10 border-bottom">
                        <div class="d-flex">
                            <div class="avatar avatar-lg avatar-image">
                                {{-- <img src="{{asset('backend/assets/images/avatars/user.jpg')}}" alt=""> --}}
                                <i class="fa fa-user text-primary"></i>
                            </div>
                            <div class="m-{{$alignShortRev}}-10">
                                <p class="m-b-0 text-dark font-weight-semibold">{{auth()->user()->name}}</p>
                                <p class="m-b-0 opacity-07">Admin</p>
                            </div>
                        </div>
                    </div>
                    <a href="{{route('backend.password.update')}}" class="dropdown-item d-block p-h-15 p-v-10">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="anticon opacity-04 ft-size-17 anticon-lock"></i>
                                </div>
                                <div class="col-auto">
                                    <span class="">Update Password</span>
                                </div>
                            </div>
                            <i class="anticon font-size-10 anticon-{{$alignreverse}}"></i>
                        </div>
                    </a>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"  class="dropdown-item d-block p-h-15 p-v-10">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="anticon opacity-04 ft-size-17 anticon-logout"></i>
                                </div>
                                <div class="col-auto">
                                    <span class="">Logout</span>
                                </div>
                            </div>
                            <i class="anticon font-size-10 anticon-{{$alignreverse}}"></i>
                        </div>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                      </form>
                </div>
            </li>
        </ul>
    </div>
</div>
