@extends('backend.layouts.app')

@section('styles')
<style type="text/css">
.kt-timeline-v2 .kt-timeline-v2__items .kt-timeline-v2__item {
    width: 100%;
    padding-left: 100px;
}
.kt-timeline-v2 .kt-timeline-v2__items .kt-timeline-v2__item .kt-timeline-v2__item-cricle {
    border: 0.8rem solid #0abea8;
    top: 2.8rem;
    width: fit-content;
    margin-right: -5px;
    position: absolute;
}
.kt-timeline-v2 {
    background: #F2F5F9;
    padding-top: 15px;
    padding-bottom: 15px;
    padding-right: 15px;
}
.kt-timeline-v2 .kt-timeline-v2__items .kt-timeline-v2__item .kt-timeline-v2__item-text {
    padding: 1rem
}
.kt-timeline-v2 {
    max-height: 230px;
    overflow-y: auto;
}
.kt-timeline-v2:before {
    background-color: #0601ff;
}
</style>
@endsection

@section('content')
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <!--Begin::Dashboard 1-->
    <!--Begin::Row-->
    <div class="row">
        <div class="col-lg-12 col-xl-8 order-lg-1 order-xl-1">
            <!--begin:: Widgets/Activity-->
            <div class="kt-portlet kt-portlet--fit kt-portlet--head-lg kt-portlet--head-overlay kt-portlet--skin-solid kt-portlet--height-fluid profile-jumper">
                <div class="row">
                	<div class="col-sm-4 text-center">
                		<div class="p-5">
                			<img src="{{ asset('backend/images/profile-a.png') }}" class="mt-4">

	                		<h5 class="mt-5 text-gray-light">Aiony Haust</h5>
	                		<h6>aionyhaust@gmail.co</h6>

	                		<button class="w-50 btn btn-default">Send Message</button>
                		</div>
                	</div>
                	<div class="col-sm-7 border-left-3">
                		<div class="p-5">
                			<h5 class="mt-4 text-gray-light">Company</h5>
	                		<h4>Marcas & Trademark Cia LLC.</h4>

	                		<div class="row">
	                			<div class="col-4">
			                		<h5 class="mt-4 text-gray-light">Name</h5>
	                				<h4>Aiony</h4>
	                			</div>
	                			<div class="col-4">
	                				<h5 class="mt-4 text-gray-light">Surname</h5>
	                				<h4>Haust</h4>
	                			</div>
                                <div class="col-4">
                                    <h5 class="mt-4 text-gray-light">Phone Number</h5>
                                    <h6>(+57) 3103178043</h6>
                                </div>
	                		</div>

                            <div class="row">
                                <div class="col-4">
                                    <h5 class="mt-4 text-gray-light">Member Status</h5>
                                    <h4>Active Member</h4>
                                </div>
                                <div class="col-4">
                                    <h5 class="mt-4 text-gray-light">Registered Date</h5>
                                    <h4>22/12/2019</h4>
                                </div>
                                
                            </div>
                		</div>


                	</div>
                </div>
            </div>


            <!--Begin::Portlet-->
            <div class="kt-portlet p-4">
                <div class="kt-portlet__head border-0">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title jumper-primary-title">
                            Query Records
                        </h3>
                    </div>
                    
                </div>
                <div class="kt-portlet__body">
                    <!--Begin::Timeline 3 -->
                    <div class="kt-timeline-v2">
                        <div class="kt-timeline-v2__items  kt-padding-top-25 kt-padding-bottom-30">
                            <div class="kt-timeline-v2__item">
                                <div class="kt-timeline-v2__item-cricle">
                                    <i class="fa fa-genderless kt-font-success"></i>
                                </div>
                                <div class="kt-timeline-v2__item-text  kt-padding-top-5 bg-white timeline-box ">
                                    <div class="row">
                                        <div class="col-2 border-right">
                                            <h5 class="text-gray-light">26/11/2020</h5>
                                            <h6>09:15 a.m.</h6>
                                        </div>

                                        <div class="col-4 border-right">
                                            <h6>Query</h6>
                                            <h5 class="text-gray-light">Tom Cruise</h5>
                                        </div>

                                        <div class="col-2">
                                            <h6>Query Type</h6>
                                            <h5 class="text-gray-light">Search</h5>
                                        </div>

                                        <div class="col-2">
                                            <h6>Results</h6>
                                            <h5 class="text-gray-light">1234</h5>
                                        </div>

                                        <div class="col-1">
                                            <i class="la la-file la-5x"></i>
                                        </div>

                                        
                                    </div>
                                                                                                                              
                                </div>
                            </div>

                            <div class="kt-timeline-v2__item">
                                <div class="kt-timeline-v2__item-cricle">
                                    <i class="fa fa-genderless kt-font-success"></i>
                                </div>
                                <div class="kt-timeline-v2__item-text  kt-padding-top-5 bg-white timeline-box ">
                                    <div class="row">
                                        <div class="col-2 border-right">
                                            <h5 class="text-gray-light">26/11/2020</h5>
                                            <h6>09:15 a.m.</h6>
                                        </div>

                                        <div class="col-4 border-right">
                                            <h6>Query</h6>
                                            <h5 class="text-gray-light">Tom Cruise</h5>
                                        </div>

                                        <div class="col-2">
                                            <h6>Query Type</h6>
                                            <h5 class="text-gray-light">Search</h5>
                                        </div>

                                        <div class="col-2">
                                            <h6>Results</h6>
                                            <h5 class="text-gray-light">1234</h5>
                                        </div>

                                        <div class="col-1">
                                            <i class="la la-file la-5x"></i>
                                        </div>

                                        
                                    </div>
                                                                                                                              
                                </div>
                            </div>

                            <div class="kt-timeline-v2__item">
                                <div class="kt-timeline-v2__item-cricle">
                                    <i class="fa fa-genderless kt-font-success"></i>
                                </div>
                                <div class="kt-timeline-v2__item-text  kt-padding-top-5 bg-white timeline-box ">
                                    <div class="row">
                                        <div class="col-2 border-right">
                                            <h5 class="text-gray-light">26/11/2020</h5>
                                            <h6>09:15 a.m.</h6>
                                        </div>

                                        <div class="col-4 border-right">
                                            <h6>Query</h6>
                                            <h5 class="text-gray-light">Tom Cruise</h5>
                                        </div>

                                        <div class="col-2">
                                            <h6>Query Type</h6>
                                            <h5 class="text-gray-light">Search</h5>
                                        </div>

                                        <div class="col-2">
                                            <h6>Results</h6>
                                            <h5 class="text-gray-light">1234</h5>
                                        </div>

                                        <div class="col-1">
                                            <i class="la la-file la-5x"></i>
                                        </div>

                                        
                                    </div>
                                                                                                                              
                                </div>
                            </div>

                            <div class="kt-timeline-v2__item">
                                <div class="kt-timeline-v2__item-cricle">
                                    <i class="fa fa-genderless kt-font-success"></i>
                                </div>
                                <div class="kt-timeline-v2__item-text  kt-padding-top-5 bg-white timeline-box ">
                                    <div class="row">
                                        <div class="col-2 border-right">
                                            <h5 class="text-gray-light">26/11/2020</h5>
                                            <h6>09:15 a.m.</h6>
                                        </div>

                                        <div class="col-4 border-right">
                                            <h6>Query</h6>
                                            <h5 class="text-gray-light">Tom Cruise</h5>
                                        </div>

                                        <div class="col-2">
                                            <h6>Query Type</h6>
                                            <h5 class="text-gray-light">Search</h5>
                                        </div>

                                        <div class="col-2">
                                            <h6>Results</h6>
                                            <h5 class="text-gray-light">1234</h5>
                                        </div>

                                        <div class="col-1">
                                            <i class="la la-file la-5x"></i>
                                        </div>

                                        
                                    </div>
                                                                                                                              
                                </div>
                            </div>
                           

                        </div>
                    </div>

                    <p class="jp-color-secondary mt-5 font-weight-bold">Show less</p>
                    <!--End::Timeline 3 -->
                </div>
            </div>
            <!--End::Portlet--> 
           	
           	
        </div>
        <div class="col-lg-6 col-xl-4 order-lg-1 order-xl-1">
            

            <!--begin:: Widgets/Revenue Change-->
            <div class="kt-portlet">
                <div class="kt-widget14">
                    <div class="kt-widget14__header">
                        <h3 class="kt-widget14__title jumper-primary-title">
                            Office   
                        </h3>
                    </div>
                    <div class="">
                        <div class="form-group">
                            <label>User</label>
                            <input type="email" class="form-control" aria-describedby="emailHelp" placeholder="xyz@gmail.co">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="email" class="form-control" aria-describedby="emailHelp" placeholder="********">
                        </div>
                    </div>
                    <div class="text-right">
                    	<button class="btn btn-brand">Reset Password</button>
                    </div>
                </div>
            </div>
            
        </div>

    </div>
    <!--End::Row-->
    
    <!--End::Dashboard 1--> 
</div>
@endsection