@extends('backend.layouts.app')
@section("title")
    {{"Fixr - Dashboard"}}
@endsection

@section('styles')
<style>
    .stats-icon{
        font-size: 27px;
        color: #66554b;
    }

    .stats-val{
        color: #e31c79;
    }
</style>
@endsection

@section('content')
    <div class="main-content">
        <div class="row">
            <div class="col-lg-4 d-none">
                <div class="card">
                    <div class="card-body">
                        <h5>Task</h5>
                        <div class="m-v-45 text-center" style="height: 220px">
                            <canvas class="chart" id="customer-chart"></canvas>
                        </div>
                        <div class="row p-t-25">
                            <div class="col-md-8 m-h-auto">
                                <div class="d-flex justify-content-between align-items-center m-b-20">
                                    <p class="m-b-0 d-flex align-items-center">
                                        <span class="badge badge-warning badge-dot m-{{$alignShort}}-10"></span>
                                        <span>New</span>
                                    </p>
                                    <h5 class="m-b-0">350</h5>
                                </div>
                                <div class="d-flex justify-content-between align-items-center m-b-20">
                                    <p class="m-b-0 d-flex align-items-center">
                                        <span class="badge badge-primary badge-dot m-{{$alignShort}}-10"></span>
                                        <span>Pending</span>
                                    </p>
                                    <h5 class="m-b-0">450</h5>
                                </div>
                                <div class="d-flex justify-content-between align-items-center m-b-20">
                                    <p class="m-b-0 d-flex align-items-center">
                                        <span class="badge badge-danger badge-dot m-{{$alignShort}}-10"></span>
                                        <span>old</span>
                                    </p>
                                    <h5 class="m-b-0">100</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5>Recent Contracts</h5>
                            {{-- <div>
                                <a href="javascript:void(0);" class="btn btn-sm btn-default">View All</a>
                            </div> --}}
                        </div>
                        <div class="m-t-30">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="bold">#</th>
                                            <th>Type</th>
                                            <th>Customer/Vendor</th>
                                            <th>User</th>
                                            <th>Start date</th>
                                            <th>End date</th>
                                            <th>Renewal date</th>
                                            <th>Renewal Deadline date</th>
                                            <th>Contract value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recent_contracts as $key => $contract)
                                            <tr>
                                                <td>{{++$key}}</td>
                                                <td class="name-badge p-3">{{ $contract->user_type ?? '' }}</td>
                                                <td>{{ $contract->user->name ?? '' }}</td>
                                                <td>{{ $contract->association->name ?? '' }}</td>
                                                <td>{{ $contract->start_date ?? '' }}</td>
                                                <td>{{ $contract->end_date ?? '' }}</td>
                                                <td class="{{\Carbon\Carbon::parse($contract->renewal_date)->lt(now()) ? 'text-danger' : ''}}">{{ $contract->renewal_date ?? '' }}</td>
                                                <td>{{ $contract->renewal_reminder_date ?? '' }}</td>
                                                <td>{{ $contract->contract_value ?? '' }}</td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-zoom/0.6.6/chartjs-plugin-zoom.js"></script>
<script>

</script>

@endsection
