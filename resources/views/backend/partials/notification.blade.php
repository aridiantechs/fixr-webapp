<div class="overflow-y-auto relative scrollable" style="max-height: 300px">
    @foreach ($all_notify as $notify)
        <a href="javascript:void(0);" class="dropdown-item d-block p-15 border-bottom">
            <div class="d-flex">
                <div class="avatar avatar-blue avatar-icon">
                    <i class="anticon anticon-mail"></i>
                </div>
                <div class="m-{{$alignShortRev}}-15">
                    <p class="m-b-0 text-dark">{{$notify->title ?? ''}}</p>
                    <p class="m-b-0"><small>{{\Carbon\Carbon::parse($notify->created_at ?? '')->diffForHumans()}}</small></p>
                </div>
            </div>
        </a>
    @endforeach
</div>