
@extends('backend.layouts.app')

@section('styles')
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/base/jquery-ui.css">
<style>
.field-icon {
    float: right;
    margin-right: 5px;
    margin-top: -25px;
    position: relative;
    z-index: 2;
}
</style>
@endsection

@section('content')
    <!-- Content Wrapper START -->
    <div class="main-content">
        <div class="page-header">
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash d-flex">
                    <a href="{{route('backend.dashboard')}}" class="breadcrumb-item"><i class="anticon anticon-home m-{{$alignShort}}-5"></i>Home</a>
                    <span class="breadcrumb-item active">Update Password</span>
                </nav>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title font-size-18">Update Password</h4>
            </div>
            <div class="card-body">
                @include('backend.partials.errors')
                <form action="{{route('backend.password.update')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-8 mx-auto">
                            
                            <div class="text-danger mb-2">
                                {{ session('password_error') }}
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <small style="color: red;display: none" id="required_old_pass" >Old password is required</small>
                                        <label class="form-control-label">Old password</label>
                                        <input id="old__password" class="form-control" name="old_pass" type="password">
        
                                        <span toggle="#old__password" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
                                        <small style="color: red;display: none" id="error_old_pass" >Please enter correct old password</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">New password</label>
                                        <input id="new__password" class="form-control password" name="password" type="password" onkeyup="getPassword()" autocomplete="new-password">
                                        <span toggle="#new__password" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
                                        <small style="color: red;display: none" id="required_new_pass" >New password is required</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Confirm password</label>
                                        <input id="confirm__password" class="form-control password_confirmation" name="password_confirmation" type="password" onkeyup="getPassword()" autocomplete="new-password">
                                        <span toggle="#confirm__password" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary m-t-30">Submit</button>
                                </div>
                            </div>  
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <!-- Content Wrapper END -->

@endsection
@section('scripts')
<!-- Third Party Scripts(used by this page)-->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script type="text/javascript">
   
    $(document).ready(function(){
        
        $(".toggle-password").click(function() {

            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    })

</script>

@endsection
