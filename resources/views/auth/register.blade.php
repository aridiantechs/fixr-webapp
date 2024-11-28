@extends('frontend.layouts.app')
 
@section('title') Register @endsection
@section('styles')
 
    <link href="{{ url('/') }}/backend/assets/vendors/custom/jstree/jstree.bundle.css" rel="stylesheet" type="text/css" />
    <style>
        .jstree-default .jstree-anchor {
    color: #a2a5b9;
    padding: 0 8px 0 4px; }

    .jstree-default .jstree-icon {
    color: #a2a5b9;
    font-size: 1.3rem; }
    .jstree-default .jstree-icon.la {
        font-size: 1.5rem; }
    .jstree-default .jstree-icon.fa {
        font-size: 1.2rem; }

    .jstree-default .jstree-disabled {
    cursor: not-allowed;
    line-height: auto;
    height: auto;
    opacity: 0.7; }
    .jstree-default .jstree-disabled .jstree-icon {
        color: #a2a5b9; }

    .jstree-default .jstree-clicked {
    border: 0;
    background: #f7f8fa;
    -webkit-box-shadow: none;
    box-shadow: none; }

    .jstree-default .jstree-hovered {
    border: 0;
    background-color: #f7f8fa;
    -webkit-box-shadow: none;
    box-shadow: none; }

    .jstree-default .jstree-wholerow-clicked,
    .jstree-default .jstree-wholerow-clicked {
    background: #ebedf2;
    -webkit-box-shadow: none;
    box-shadow: none; }

    .jstree-default .jstree-wholerow-hovered,
    .jstree-default.jstree-wholerow .jstree-wholerow-hovered {
    border: 0;
    background-color: #f7f8fa;
    -webkit-box-shadow: none;
    box-shadow: none; }

    .jstree-open > .jstree-anchor > .fa-folder:before {
    margin-left: 2px;
    content: "\f07c"; }

    .jstree-open > .jstree-anchor > .la-folder:before {
    margin-left: 2px;
    content: "\f200"; }

    .jstree-default.jstree-rtl .jstree-node {
    background-position: 100% 1px/*rtl:ignore*/ !important; }

    .jstree-default.jstree-rtl .jstree-last {
    background: transparent /*rtl:ignore*/;
    background-repeat: no-repeat; }

    .jstree-rtl .jstree-anchor {
    padding: 0 4px 0 8px/*rtl:ignore*/; }

    .w-full {
        width: 100%;
    }

    .shadow-sm {
        box-shadow: 0 1px 2px 0 rgb(0 0 0 / 5%);
    }
    .mt-1 {
        margin-top: 0.25rem;
    }
    .block {
        display: block;
    }
    .rounded-md {
        border-radius: 0.375rem;
    }
    .border-gray-300 {
        --border-opacity: 1;
        border-color: #d2d6dc;
        border-color: rgba(210, 214, 220, var(--border-opacity));
    }

    .text-gray-700 {
        --text-opacity: 1;
        color: #374151;
        color: rgba(55, 65, 81, var(--text-opacity));
    }

    .text-sm {
        font-size: 0.875rem;
    }

    .font-medium {
        font-weight: 500;
    }

    .block {
        display: block;
    }

    .justify-center{
        justify-content: center !important;
    }

    .font-16{
        font-size: 16px;
    }

    .p-2.5 {
        padding: 2.5rem !important;
    }
    </style>
@endsection
@section('content')

<div class="row">
    <div class="col-md-4 mx-auto">
 
        <div class="kt-portlet">
            <div class="kt-portlet__head justify-center">
                <div class="kt-portlet__head-label">
                    <h2 class="kt-portlet__head-title">
                        Register
                    </h2>
                </div>
            </div>
            <div class="kt-portlet__bodyt p-5">
                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-label class="font-16" for="fname" :value="__('Förnamn')" />

                        <x-input id="f_name" class="block mt-1 w-full form-control" type="text" name="f_name" :value="old('f_name')" required autofocus />
                    </div>

                    <!-- Name -->
                    <div class="mt-4">
                        <x-label class="font-16" for="l_name" :value="__('Efternamn')" />

                        <x-input id="l_name" class="block mt-1 w-full form-control" type="text" name="l_name" :value="old('l_name')" required autofocus />
                    </div>

                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-label class="font-16" for="email" :value="__('Email')" />

                        <x-input id="email" class="block mt-1 w-full form-control" type="email" name="email" :value="old('email')" required />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-label class="font-16" for="password" :value="__('lösenord')" />

                        <x-input id="password" class="block mt-1 w-full form-control"
                                        type="password"
                                        name="password"
                                        required autocomplete="new-password" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-label class="font-16" for="password_confirmation" :value="__('Bekräfta lösenord')" />

                        <x-input id="password_confirmation" class="block mt-1 w-full form-control"
                                        type="password"
                                        name="password_confirmation" required />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>

                        <x-button class="ml-4 btn-primary">
                            {{ __('Register') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</div>

@endsection

@section('scripts')
 <!--begin::Page Vendors(used by this page) -->
    <script src="{{ url('/') }}/backend/assets/vendors/custom/jstree/jstree.bundle.js" type="text/javascript"></script>
<!--end::Page Vendors -->

<!--begin::Page Scripts(used by this page) -->
    <script src="{{ url('/') }}/backend/assets/js/demo1/pages/components/extended/treeview.js" type="text/javascript"></script>
<!--end::Page Scripts -->
@endsection
