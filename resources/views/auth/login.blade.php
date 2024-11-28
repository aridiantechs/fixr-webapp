<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Fixr - Login </title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{asset('backend/assets/images/fixr-favicon.jpg')}}">

    <!-- page css -->

    <!-- Core css -->
    <link href="{{asset('backend/assets/css/app.min.css')}}" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
    <style>
        .text-color1{
            color: #e31c79;
        }

        .text-color2{
            color: #66554b;
        }

        body{
            font-size: 1rem !important;
        }

        .form-control {
            padding: 1rem 2.2rem !important;
        }

        .card {
            border: none !important;
        }

        h1{
            font-size: 2.5rem !important;
        }
    </style>
</head>

<body>
    <div class="app">
        <div class="container-fluid p-h-0 p-v-20 bg full-height d-flex bg-white">
            <div class="d-flex flex-column justify-content-between w-100">
                <div class="container d-flex h-100">
                    <div class="row align-items-center w-100">
                        <div class="col-md-7 col-lg-5 m-h-auto">
                            <div class="card {{-- shadow-lg --}}">
                                <div class="card-body">
                                    <div class="d-flex text-center justify-content-center m-b-30">
                                        {{-- <img class="img-fluid" alt="" width="300" src="{{asset('backend/assets/images/fixr-logo.jpg')}}"> --}}
                                        {{-- <h1 class="m-b-0 w-100"><span class="text-color1">Cont</span><span class="text-color2"> Man</span></h1> --}}
                                        {{-- <h2 class="m-b-0 text-color2">Sign In</h2> --}}
                                        <div style="width: 200px;">
                                            
                                            <svg class="sc-e251f6e9-2 fNXbIw" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 435 138"><g clip-path="url(#:R1b9rmH1:)" fill-rule="evenodd" clip-rule="evenodd"><path d="M405.825 92.722c16.275-8.108 25.206-23.33 25.206-44.485 0-30.842-21.038-48.24-57.754-48.24H341.39l-30.234 42.6v95.4h35.33V99.049h27.787l20.641 38.948h40.09l-29.179-45.276Zm-32.548-20.958h-26.793V27.677h26.791c15.282 0 24.213 7.314 24.213 21.747.002 14.633-8.929 22.343-24.213 22.343l.002-.003ZM35.329 138H0V0h103.005v27.285H35.327v32.032H97.65v27.675h-62.32V138Zm175.198-69 20.472-28.843L259.5 0h40.941L251.47 68.996l-20.471 28.842-28.501 40.157h-40.942l48.971-68.996Zm-8.029-69 8.026 11.31-20.47 28.844L161.556 0h40.942Zm48.973 126.69 8.027 11.309h40.941l-28.497-40.152-20.471 28.843Zm-95.532-38.465L120.61 138V0h35.329v88.225Z"></path><path d="M405.825 92.722c16.275-8.108 25.206-23.33 25.206-44.485 0-30.842-21.038-48.24-57.754-48.24H341.39l-30.234 42.6v95.4h35.33V99.049h27.787l20.641 38.948h40.09l-29.179-45.276Zm-32.548-20.958h-26.793V27.677h26.791c15.282 0 24.213 7.314 24.213 21.747.002 14.633-8.929 22.343-24.213 22.343l.002-.003ZM35.329 138H0V0h103.005v27.285H35.327v32.032H97.65v27.675h-62.32V138Zm175.198-69 20.472-28.843L259.5 0h40.941L251.47 68.996l-20.471 28.842-28.501 40.157h-40.942l48.971-68.996Zm-8.029-69 8.026 11.31-20.47 28.844L161.556 0h40.942Zm48.973 126.69 8.027 11.309h40.941l-28.497-40.152-20.471 28.843Zm-95.532-38.465L120.61 138V0h35.329v88.225Z" fill="url(#:R1b9rm:)"></path></g><defs><linearGradient id=":R1b9rm:" x1="-1.61" y1="147.67" x2="433.181" y2="157.816" gradientUnits="userSpaceOnUse"><stop offset=".123" stop-color="#CC013E"></stop><stop offset="1" stop-color="#FF2000"></stop></linearGradient><clipPath id=":R1b9rmH1:"><path fill="#fff" d="M0 0h435v138H0z"></path></clipPath></defs></svg>
                                        </div>
                                    </div>
                                    
                                    <form method="POST" action="{{ route('login') }}">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label class="font-weight-semibold" for="email">Email:</label>
                                            <div class="input-affix">
                                                <i class="prefix-icon anticon anticon-user"></i>
                                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="email">
                                                
                                            </div>
                                            @error('email')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="font-weight-semibold" for="password">Password:</label>
                                            {{-- <a class="float-right font-size-13 text-muted" href="{{ route('password.request') }}">Forget Password?</a> --}}
                                            <div class="input-affix m-b-10">
                                                <i class="prefix-icon anticon anticon-lock"></i>
                                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password">
                                            </div>
                                            @error('password')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <div class="d-flex align-items-center justify-content-between">
                                                {{-- <span class="font-size-13 text-muted">
                                                    Don't have an account? 
                                                    <a href="{{ route('register') }}"> Signup</a>
                                                </span> --}}
                                                <button class="btn btn-primary w-100 text-white">Sign In</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-none d-md-flex p-h-40 justify-content-between">
                    <span class="">© 2024 Fixr</span>
                    {{-- <ul class="list-inline">
                        <li class="list-inline-item">
                            <a class="text-dark text-link" href="">Legal</a>
                        </li>
                        <li class="list-inline-item">
                            <a class="text-dark text-link" href="">Privacy</a>
                        </li>
                    </ul> --}}
                </div>
            </div>
        </div>
    </div>


    <!-- Core Vendors JS -->
    <script src="{{asset('backend/assets/js/vendors.min.js')}}"></script>

    <!-- page js -->

    <!-- Core JS -->
    <script src="{{asset('backend/assets/js/app.min.js')}}"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            @if(session()->has('error'))
                toastr.error('{{ session('error') }}')
            @endif
    
            @if(session()->has('warning'))
                toastr.warning('{{ session('warning') }}')
            @endif
    
                
            @if(session()->has('status'))
                toastr.success('{{ session('status') }}')
            @endif
        });
    </script>
</body>

</html>