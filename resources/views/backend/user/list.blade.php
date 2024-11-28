@extends('backend.layouts.app')

@section('styles')
<style>
    /*Profile card 2*/
.profile-card-2 .card-img-block{
    float:left;
    width:100%;
    height:150px;
    overflow:hidden;
}
.profile-card-2 .card-body{
    position:relative;
}
.profile-card-2 .profilee {
  border-radius: 50%;
  position: absolute;
  top: -50px;
    left: 50%;
    max-width: 100px;
    height: 100px;
  border: 3px solid rgba(255, 255, 255, 1);
  -webkit-transform: translate(-50%, 0%);
  transform: translate(-50%, 0%);
}
.profile-card-2 h5{
    font-weight:600;
    color:#6ab04c;
}
.profile-card-2 .card-text{
    font-size:15px;
}
.profile-card-2 .icon-block{
    float:left;
    width:100%;
}
.profile-card-2 .icon-block a{
    text-decoration:none;
}
.profile-card-2 i {
  display: inline-block;
    font-size: 16px;
    color: #6ab04c;
    text-align: center;
    border: 1px solid #6ab04c;
    width: 30px;
    height: 30px;
    line-height: 30px;
    border-radius: 50%;
    margin:0 5px;
}
.profile-card-2 i:hover {
  background-color:#6ab04c;
  color:#fff;
}
</style>
@endsection

@section('content')
    @php
        $user_type=\Str::ucFirst(request()->query('type') ? (request()->query('type')=='employee' ? 'User' : request()->query('type')) :'User');
    @endphp
    <!-- Content Wrapper START -->
    <div class="main-content">
        <div class="page-header">
            <h2 class="header-title">Users & Admins</h2>
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="{{route('backend.company.index')}}" class="breadcrumb-item"><i class="anticon anticon-home m-{{$alignShort}}-5"></i>Home</a>
                    <span class="breadcrumb-item active">Users & Admins</span>
                </nav>
            </div>
        </div>

        <div class="card p-r-15 p-l-15">
            <div class="row align-items-md-center">
                <div class="col-md-6">
                    <div class="media m-v-10">
                        <div class="avatar avatar-cyan avatar-icon avatar-square">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="media-body m-{{$alignShortRev}}-15">
                            <h6 class="mb-0">All {{$user_type}}s</h6>
                            {{-- <span class="text-gray font-size-13">Sanad Team</span> --}}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text-md-{{$alignreverse}} m-v-10">
                        @if (hasPermission('Add Data'))
                            <a href="{{route('backend.user.create')}}{{request()->query('type') ? '?type='.request()->query('type') : ''}}" class="btn btn-primary m-{{$alignShortRev}}-15">
                                <span>Add new {{$user_type}}</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form class="form-row" action="{{ getFullUrl() }}">
                    <h3 class="col-md-12">Search</h3>
                    <hr>
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control" id="search_text" name="search_text" value="{{request()->query('search_text')}}">
                    </div>
                    <div class="form-group col-md-2">
                        <button class="btn btn-primary" type="submit">Go</button>
                    </div>
                    
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <!-- Card View -->
                <div class="row" id="list-view">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
											<tr>
												<th>#</th>
											   <th>Name</th>
											   <th>Email</th>
											   <th>Role</th>
											   {{-- <th>Active</th> --}}
											   @if (hasPermission('View Data') || hasPermission('Update Data') || hasPermission('Delete Data'))
											   <th>Operation</th>
											   @endif
											</tr>
										</thead>
										<tbody>
											@foreach($users as $key => $user)
												<tr>
													<td>{{++$key}}</td>
													<td class="name-badge p-3">{{ $user->first_name ?? '' }} {{ $user->last_name ?? '' }}
			
													</td>
													<td>{{ $user->email ?? '' }}</td>
													<td>
														@foreach ($user->roles as $role)
															{{ ucfirst(($role->name=='employee' ? 'user' :$role->name ) ?? '') }}
															<br>
														@endforeach
													</td>
													
													<td>
                                                        {{-- <div class="dropdown dropdown-inline">
                                                            <button type="button" class="btn btn-default btn-icon btn-sm btn-icon-md" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="flaticon-more"></i>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                @if(auth()->user()->hasRole('superadmin') || auth()->user()->hasPermissionTo('edit-data'))
                                                                    <a class="dropdown-item" href="{{route('backend.report.show',$user->id)}}" ><i class="fas fa-eye"></i>View</a>
                                                                @endif
                                                            </div>
                                                        </div> --}}
                                                        @if (hasPermission('Delete Data'))
                                                            @include('backend.components.delete',[
                                                                'data' => $user->id, 
                                                                'route' =>route('backend.user.destroy',$user->id), 
                                                            ])
                                                        @endif

                                                        @if (hasPermission('Update Data'))
                                                            <a href="{{route('backend.user.edit',md5($user->id))}}?type={{$user->roles()->first()->name ?? ''}}" class="btn btn-success btn-tone">
                                                                <i class="fas fa-edit "></i>
                                                                <span class="m-{{$alignShortRev}}-5">Edit</span>
                                                            </a>
                                                        @endif
                                                        @if (hasPermission('View Data'))
                                                            <a href="javascript:void(0)" class="btn btn-info btn-tone profile" data-user-id="{{md5($user->id)}}">
                                                                <i class="fas fa-eye "></i>
                                                                <span class="m-{{$alignShortRev}}-5">View</span>
                                                            </a>
                                                        @endif
													</td>
												</tr>
											@endforeach
										</tbody>
                                    </table>
                                </div>
                                {!!$users->links()!!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Search Start-->
    <div class="modal modal-left fade search" id="search-drawer">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header justify-content-between align-items-center">
                    <h5 class="modal-title">Search</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="anticon anticon-close"></i>
                    </button>
                </div>
                <div class="modal-body scrollable">
                    <div class="input-affix">
                        <i class="prefix-icon anticon anticon-search"></i>
                        <input type="text" class="form-control" placeholder="Search">
                    </div>
                    <div class="m-t-30">
                        <h5 class="m-b-20">Files</h5>
                        <div class="d-flex m-b-30">
                            <div class="avatar avatar-cyan avatar-icon">
                                <i class="anticon anticon-file-excel"></i>
                            </div>
                            <div class="m-l-15">
                                <a href="javascript:void(0);" class="text-dark m-b-0 font-weight-semibold">Quater Report.exl</a>
                                <p class="m-b-0 text-muted font-size-13">by Finance</p>
                            </div>
                        </div>
                        <div class="d-flex m-b-30">
                            <div class="avatar avatar-blue avatar-icon">
                                <i class="anticon anticon-file-word"></i>
                            </div>
                            <div class="m-l-15">
                                <a href="javascript:void(0);" class="text-dark m-b-0 font-weight-semibold">Documentaion.docx</a>
                                <p class="m-b-0 text-muted font-size-13">by Developers</p>
                            </div>
                        </div>
                        <div class="d-flex m-b-30">
                            <div class="avatar avatar-purple avatar-icon">
                                <i class="anticon anticon-file-text"></i>
                            </div>
                            <div class="m-l-15">
                                <a href="javascript:void(0);" class="text-dark m-b-0 font-weight-semibold">Recipe.txt</a>
                                <p class="m-b-0 text-muted font-size-13">by The Chef</p>
                            </div>
                        </div>
                        <div class="d-flex m-b-30">
                            <div class="avatar avatar-red avatar-icon">
                                <i class="anticon anticon-file-pdf"></i>
                            </div>
                            <div class="m-l-15">
                                <a href="javascript:void(0);" class="text-dark m-b-0 font-weight-semibold">Project Requirement.pdf</a>
                                <p class="m-b-0 text-muted font-size-13">by Project Manager</p>
                            </div>
                        </div>
                    </div>
                    <div class="m-t-30">
                        <h5 class="m-b-20">Members</h5>
                        <div class="d-flex m-b-30">
                            <div class="avatar avatar-image">
                                <img src="assets/images/avatars/thumb-1.jpg" alt="">
                            </div>
                            <div class="m-l-15">
                                <a href="javascript:void(0);" class="text-dark m-b-0 font-weight-semibold">Erin Gonzales</a>
                                <p class="m-b-0 text-muted font-size-13">UI/UX Designer</p>
                            </div>
                        </div>
                        <div class="d-flex m-b-30">
                            <div class="avatar avatar-image">
                                <img src="assets/images/avatars/thumb-2.jpg" alt="">
                            </div>
                            <div class="m-l-15">
                                <a href="javascript:void(0);" class="text-dark m-b-0 font-weight-semibold">Darryl Day</a>
                                <p class="m-b-0 text-muted font-size-13">Software Engineer</p>
                            </div>
                        </div>
                        <div class="d-flex m-b-30">
                            <div class="avatar avatar-image">
                                <img src="assets/images/avatars/thumb-3.jpg" alt="">
                            </div>
                            <div class="m-l-15">
                                <a href="javascript:void(0);" class="text-dark m-b-0 font-weight-semibold">Marshall Nichols</a>
                                <p class="m-b-0 text-muted font-size-13">Data Analyst</p>
                            </div>
                        </div>
                    </div>
                    <div class="m-t-30">
                        <h5 class="m-b-20">News</h5>
                        <div class="d-flex m-b-30">
                            <div class="avatar avatar-image">
                                <img src="assets/images/others/img-1.jpg" alt="">
                            </div>
                            <div class="m-l-15">
                                <a href="javascript:void(0);" class="text-dark m-b-0 font-weight-semibold">5 Best Handwriting Fonts</a>
                                <p class="m-b-0 text-muted font-size-13">
                                    <i class="anticon anticon-clock-circle"></i>
                                    <span class="m-l-5">25 Nov 2018</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Search End-->

    <!-- Quick View START -->
    <div class="modal modal-right fade quick-view" id="quick-view">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header justify-content-between align-items-center">
                    <h5 class="modal-title">Theme Config</h5>
                </div>
                <div class="modal-body scrollable">
                    <div class="m-b-30">
                        <h5 class="m-b-0">Header Color</h5>
                        <p>Config header background color</p>
                        <div class="theme-configurator d-flex m-t-10">
                            <div class="radio">
                                <input id="header-default" name="header-theme" type="radio" checked value="default">
                                <label for="header-default"></label>
                            </div>
                            <div class="radio">
                                <input id="header-primary" name="header-theme" type="radio" value="primary">
                                <label for="header-primary"></label>
                            </div>
                            <div class="radio">
                                <input id="header-success" name="header-theme" type="radio" value="success">
                                <label for="header-success"></label>
                            </div>
                            <div class="radio">
                                <input id="header-secondary" name="header-theme" type="radio" value="secondary">
                                <label for="header-secondary"></label>
                            </div>
                            <div class="radio">
                                <input id="header-danger" name="header-theme" type="radio" value="danger">
                                <label for="header-danger"></label>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div>
                        <h5 class="m-b-0">Side Nav Dark</h5>
                        <p>Change Side Nav to dark</p>
                        <div class="switch d-inline">
                            <input type="checkbox" name="side-nav-theme-toogle" id="side-nav-theme-toogle">
                            <label for="side-nav-theme-toogle"></label>
                        </div>
                    </div>
                    <hr>
                    <div>
                        <h5 class="m-b-0">Folded Menu</h5>
                        <p>Toggle Folded Menu</p>
                        <div class="switch d-inline">
                            <input type="checkbox" name="side-nav-fold-toogle" id="side-nav-fold-toogle">
                            <label for="side-nav-fold-toogle"></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Quick View END -->

    <div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog profile_modal_div" role="document">
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.14.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/2.1.23/daterangepicker.min.js"></script>
<script type="text/javascript">
	
	$(document).ready(function(){
		/* $("[name='status']").bootstrapSwitch(); */

		$("[name='status']").on('switchChange.bootstrapSwitch',function (e, state) {
			/* console.log($(this).data('userid')); */
			const that=this;
			$.get("{{ route('backend.user.updateStatus') }}",
			{
				user_id: $(this).data('userid'),
				status:state==true?1 : 0
			},
			function(status){
				
				if (status=="success") {
					$(that).bootstrapSwitch('state', state, true);
				} else {
					$(that).bootstrapSwitch('state', !state, true);
				}
			});
			
		});

		@if($errors->has('member_id') || $errors->has('title') || $errors->has('description') )
			$('#picklist-modal').modal('show');
		@endif
		
		$('#daterange').daterangepicker({
			// minDate: moment().startOf('day'),
		});
		@if(request()->query('date')=='')
			$('#daterange').val('');
		@endif
		
	});


    $(document).on('click','.profile',function(e){
        e.preventDefault();
        // fullPageLoader(true);
        var cat_id=$(this).data('user-id');

        $.ajax({
            url: "{{ url('/') }}/backend/user/"+cat_id,
            type: 'GET',
            success: function (res) {
                // fullPageLoader(false);
                if (res.status=='success') {
                    $(' .profile_modal_div').html(res.data);
                    $('#profileModal').modal('toggle');
                }
                else if(res.status=='error') {
                    toastr.success(res.message)
                }
            }
        });
        
    });
</script>

<script>
	
</script>

@endsection