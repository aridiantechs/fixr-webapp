 <!-- Core Vendors JS -->
 <script src="{{asset('backend/assets/js/vendors.min.js')}}"></script>

 <!-- page js -->
 <script src="{{asset('backend/assets/vendors/chartjs/Chart.min.js')}}"></script>
 <script src="{{asset('backend/assets/js/pages/dashboard-e-commerce.js')}}"></script>

 <!-- Core JS -->
 <script src="{{asset('backend/assets/js/app.min.js')}}"></script>

<script src="{{asset('js/confirm-dialog.js')}}"></script>
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