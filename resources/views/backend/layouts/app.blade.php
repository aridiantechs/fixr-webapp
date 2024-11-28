@inject('request', 'Illuminate\Http\Request')
<!DOCTYPE html>
<html lang="en" >
    <title>@yield('title')</title>

    <head>
        @include('backend.partials.header')

        @yield('styles')

        <style>

            * {
                font-family: "Quicksand";
            }

            .error{
                    color: red;
                }

            body{
                font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
            }

            .is-folded .side-nav .side-nav-inner .side-nav-menu>li>a.dropdown-toggle{
                padding-left: 15px !important;
            }

            .text-color1{
                color: #e31c79;
            }

            .text-color2{
                color: #66554b;
            }

            @media only screen and (min-width: 992px)
            {
                .is-folded .header .logo h1.logo-unfold {
                    display: none;
                }
            }

            .anticon{
                line-height: unset !important;
            }

            .ft-size-17{
                font-size: 17px !important;
                line-height: 1.2 !important;
            }
        </style>
    </head>
    <!-- end::Head -->
    <!-- begin::Body -->
    <body>
        <div class="app">
            <div class="layout">
                <!-- begin:: BODY -->
                @include('backend.partials.extra')
                @include('backend.partials.navbar')

                @include('backend.partials.sidebar')

                <div class="page-container">

                    @yield('content')

                    <!-- begin:: Footer -->
                    @include('backend.partials.footbar')
                    <!-- end:: Footer -->
                </div>
            </div>
        </div>
        @include('backend.components.confirm-dialog')

        @include('backend.partials.footer')
        @yield('scripts')
    </body>
</html>
