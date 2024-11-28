@extends('backend.layouts.app')
{{-- {{ dd($contents) }} --}}
@section('styles')
<!--Third party Styles(used by this page)--> 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" integrity="sha512-gxWow8Mo6q6pLa1XH/CcH8JyiSDEtiwJV78E+D+QP0EVasFs8wKXq16G8CLD4CJ2SnonHr4Lm/yY2fSI2+cbmw==" crossorigin="anonymous" />
<style>
   .kt-widget.kt-widget--user-profile-3 .kt-widget__top .kt-widget__pic{
      max-width: 90px;
    height: 90px;
   }
</style>
@endsection
@section('content')
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
   <div class="row">
      <div class="col-md-12">
         <!--begin::Portlet-->
         <div class="kt-portlet">
            <div class="kt-portlet__body">
               <div class="kt-widget kt-widget--user-profile-3">
                  <div class="kt-widget__top">
                        <div class="kt-widget__media kt-hidden">
                           <img src="./assets/media/users/100_1.jpg" alt="image">
                        </div>
                        <div class="kt-widget__pic kt-widget__pic--danger kt-font-danger kt-font-boldest kt-font-light kt-hidden-">
                           {{ \Str::upper($user->first_name[0]) ?? ''}} {{ \Str::upper($user->last_name[0] ?? '')}}
                        </div>
                        <div class="kt-widget__content">
                           <div class="kt-widget__head">
                              <a href="#" class="kt-widget__username">
                                 {{ $user->first_name ?? ''}} {{ $user->last_name ?? ''}}                                                  
                              </a>

                              {{-- <div class="kt-widget__action">
                                    <button type="button" class="btn btn-label-success btn-sm btn-upper">ask</button>&nbsp;
                                    <button type="button" class="btn btn-brand btn-sm btn-upper">hire</button>
                              </div> --}}
                           </div>

                           <div class="kt-widget__subhead">
                              <a href="#"><i class="flaticon2-new-email"></i>{{$user->email ?? ''}}</a>
                              <a href="#"><i class="flaticon2-calendar-3"></i>{{\Str::ucFirst($user->roles()->first()->name) ?? ''}}</a>
                              {{-- <a href="#"><i class="flaticon2-placeholder"></i>{{$user->phone ?? ''}}</a> --}}
                           </div>

                           {{-- <div class="kt-widget__info">
                              <div class="kt-widget__desc">
                                    I distinguish three main text objektive could be merely to inform people.
                                    <br> A second could be persuade people.You want people to bay objective
                              </div>
                           </div> --}}
                        </div>
                  </div>
                  <div class="kt-widget__bottom">
                     
                     <div class="kt-widget__item">
                        <div class="kt-widget__icon">
                           <i class="flaticon-file-2"></i>
                        </div>
                        <div class="kt-widget__details">
                           <span class="kt-widget__title">Total {{$user->hasRole('endUser')?'Requests' : 'Proposals'}}</span>
                           <span class="kt-widget__value">{{$user->hasRole('endUser')? $user->requests->count(): $user->proposals->count()}}</span>
                        </div>
                     </div>

                     <div class="kt-widget__item">
                        <div class="kt-widget__icon">
                           <i class="flaticon-piggy-bank"></i>
                        </div>
                        <div class="kt-widget__details">
                           <span class="kt-widget__title">Completed  {{$user->hasRole('endUser')?'Requests' : 'Proposals'}}</span>
                           <span class="kt-widget__value">{{$user->hasRole('endUser')? $user->completed_requests()->count(): $user->completed_proposals()->count()}}</span>
                        </div>
                     </div>

                     <div class="kt-widget__item">
                        <div class="kt-widget__icon">
                           <i class="flaticon-confetti"></i>
                        </div>
                        <div class="kt-widget__details">
                           <span class="kt-widget__title">Pending  {{$user->hasRole('endUser')?'Requests' : 'Proposals'}}</span>
                           <span class="kt-widget__value">{{$user->hasRole('endUser')? $user->pending_requests()->count(): $user->pending_proposals()->count()}}</span>
                        </div>
                     </div>

                     @if ($user->hasRole('supplier'))
                        <div class="kt-widget__item">
                           <div class="kt-widget__icon">
                              <i class="flaticon-confetti"></i>
                           </div>
                           <div class="kt-widget__details">
                              <span class="kt-widget__title">Accepted Proposals</span>
                              <span class="kt-widget__value">{{$user->accpted_proposals()->count()}}</span>
                           </div>
                        </div>
                     @endif

                     @if ($user->hasRole('endUser'))
                        <div class="kt-widget__item">
                           <div class="kt-widget__icon">
                              <i class="flaticon-pie-chart"></i>
                           </div>
                           <div class="kt-widget__details">
                              <span class="kt-widget__title">Total Proposals Recieved</span>
                              <span class="kt-widget__value">{{ $user->total_proposals()}}</span>
                           </div>
                        </div> 
                     @endif
                       
                  </div>
                  <div class="kt-widget__item">
                     <div class="kt-widget__contact my-4">
                        <span class="kt-widget__label"><b>First Name:</b></span>
                        <span class="kt-widget__data ml-4">{{ $user->first_name ?? ''}} </span>
                     </div>
                     <div class="kt-widget__contact my-4">
                        <span class="kt-widget__label"><b>Last Name:</b></span>
                        <span class="kt-widget__data ml-4">{{ $user->last_name ?? ''}} </span>
                     </div>
                     <div class="kt-widget__contact my-4">
                        <span class="kt-widget__label"><b>Email:</b></span>
                        <span class="kt-widget__data ml-4">{{$user->email ?? ''}}</span>
                     </div>
                     <div class="kt-widget__contact my-4">
                        <span class="kt-widget__label"><b>Phone:</b></span>
                        <span class="kt-widget__data ml-4">{{$user->phone ?? ''}}</span>
                     </div>

                     @if ($user->hasRole('supplier'))
                        <div class="kt-widget__contact my-4">
                           <span class="kt-widget__label"><b>Shop Name:</b></span>
                           <span class="kt-widget__data ml-4">{{$user->company_profile->shop_name ?? ''}}</span>
                        </div>
                        <div class="kt-widget__contact my-4">
                           <span class="kt-widget__label"><b>Shop Contact:</b></span>
                           <span class="kt-widget__data ml-4">{{$user->company_profile->shop_contact ?? ''}}</span>
                        </div>
                        <div class="kt-widget__contact my-4">
                           <span class="kt-widget__label"><b>Shop Location:</b></span>
                           <span class="kt-widget__data ml-4">{{$user->company_profile->shop_location ?? ''}}</span>
                        </div>
                        <div class="kt-widget__contact my-4">
                           <span class="kt-widget__label"><b>Additional Info:</b></span>
                           <span class="kt-widget__data ml-4">{{$user->company_profile->additional_info ?? ''}}</span>
                        </div>
                        <div class="kt-widget__contact my-4">
                           <span class="kt-widget__label"><b>Shop Logo:</b></span>
                           <span class="kt-widget__data ml-4"><img style="width: 5%;" src="{{asset($user->company_profile->shop_logo ?? '')}}" alt=""></span>
                        </div>
                     @endif
                     
                  </div>
               </div>
               <br>
            </div>
         </div>
         <!--end::Portlet-->
      </div>
   </div>
</div>
@endsection
@section('scripts')
<!-- Third Party Scripts(used by this page)-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js" integrity="sha512-DNeDhsl+FWnx5B1EQzsayHMyP6Xl/Mg+vcnFPXGNjUZrW28hQaa1+A4qL9M+AiOMmkAhKAWYHh1a+t6qxthzUw==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.14/js/utils.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.js"></script>

<script type="text/javascript">
   
   $(document).ready(function(){

      @if (session('status'))
         toastr.success('{{session('status')}}', "Success");
      @endif

      //select on change option
      $('#role').on('change', function(){
         var role = $(this).val();
         if(role == 'employee'){
            $('#permissions').show();
         }else{
            $('#permissions').hide();
         }
      });
   })

</script>

{{-------------------------}}
    {{-- input phone setting --}}
    <script>
      /* INITIALIZE BOTH INPUTS WITH THE intlTelInput FEATURE*/

      var phone = document.querySelector("#phone"),
          errorMsg = document.querySelector("#error-msg"),
          validMsg = document.querySelector("#valid-msg");
      
      // here, the index maps to the error code returned from getValidationError - see readme
      var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

      var iti=window.intlTelInput(phone,{
          initialCountry: "us",
          separateDialCode: true,
          preferredCountries: ["fr", "us", "gb"],
          geoIpLookup: function (callback) {
              $.get('https://ipinfo.io', function () {
              }, "jsonp").always(function (resp) {
                  var countryCode = (resp && resp.country) ? resp.country : "";
                  callback(countryCode);
              });
          },
          utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.14/js/utils.js"
      });

      var hiden_phone = document.querySelector("#hiden");
      window.intlTelInput(hiden_phone,{
          initialCountry: "us",
          dropdownContainer: 'body',
          utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.14/js/utils.js"
      });

      var reset = function() {
          phone.classList.remove("error");
          errorMsg.innerHTML = "";
          errorMsg.classList.add("hide");
          validMsg.classList.add("hide");
      };

      var mask1 = $("#phone").attr('placeholder').replace(/[0-9]/g, 0);

      $(document).ready(function () {
          $('#phone').mask(mask1)
      });

      $("#phone").on("countrychange", function (e, countryData) {
          $("#phone").val('');
          var mask1 = $("#phone").attr('placeholder').replace(/[0-9]/g, 0);
          $('#phone').mask(mask1);

      });

      // on blur: validate
      phone.addEventListener('blur', function() {
      reset();
      if (phone.value.trim()) {
          if (iti.isValidNumber()) {
          validMsg.classList.remove("hide");
          } else {
          phone.classList.add("error");
          var errorCode = iti.getValidationError();
          errorMsg.innerHTML = errorMap[errorCode];
          errorMsg.classList.remove("hide");
          }
      }
      });

      $('input.hide').parent().hide();

      // on keyup / change flag: reset
      phone.addEventListener('change', reset);
      phone.addEventListener('keyup', reset);

  </script>
  {{-- end input phone setting --}}
  {{-------------------------}}

  <script>
      // $('#registerSubmitBtn').on('click',function(e){
      //     e.preventDefault();
      //     if (iti.isValidNumber()) {
      //         var country_data=iti.getSelectedCountryData();
      //         console.log(country_data);
      //         document.getElementById("hiden").value = JSON.stringify(country_data);
      //         $('#registerForm').submit();
      //     } else {
      //         phone.classList.add("error");
      //         var errorCode = iti.getValidationError();
      //         errorMsg.innerHTML = errorMap[errorCode];
      //         errorMsg.classList.remove("hide");
      //         $('html, body').animate({
      //             scrollTop: $("#phone-div").position().top
      //         }, 800);
      //         return false;
      //     }
      // })
  </script>

  <script>
      var today = new Date();
      var dd = today.getDate();
      var mm = today.getMonth()+1; //January is 0!
      var yyyy = today.getFullYear();
      if(dd<10){
              dd='0'+dd
          } 
          if(mm<10){
              mm='0'+mm
          } 

      today = yyyy+'-'+mm+'-'+dd;
      document.getElementById("dob").setAttribute("max", today)
  </script>
@endsection