<!-- for card -->
<div class="modal-content">
    <div class="modal-header">
        
        <h4 class="mt-3 w-100 float-left text-center"><strong>Profile Card</strong></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="card profile-card-2 mt-5">
                    <div class="card-body pt-5">
                        <img src="{{\File::exists(public_path()."/storage/public/uploads/users/".$user->getAttributes()['profile_image']) ?$user->profile_image : asset('backend/assets/images/avatars/thumb-1.jpg') }}" alt="profile-image" class="profilee"/>
                        <h5 class="card-title">{{$user->name}}</h5>
                        <p class="card-text"><strong>Email: </strong>{{$user->email}}</p>
                        <p class="card-text"><strong>Phone: </strong>{{$user->phone}}</p>
                        @if ($user->designation)
                            <p class="card-text"><strong>Designation: </strong>{{$user->designation}}</p>
                        @endif
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- for card end-->