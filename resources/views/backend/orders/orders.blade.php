@extends('backend.layouts.app')
@section("title")
    {{"Fixr - Orders"}}
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
                        <h1>Orders</h1>
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
                            <h1>Orders</h1>
                            {{-- <div>
                                <a href="javascript:void(0);" class="btn btn-sm btn-default">View All</a>
                            </div> --}}
                        </div>
                        <div class="m-t-30">
                            <div class="table-responsive" id="live_tracking_table">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="bold">#</th>
                                            <th>uuid</th>
                                            <th>user</th>
                                            <th>type</th>
                                            <th>payload</th>
                                            <th>created at</th>
                                            <th>updated at</th>
                                            <th>view order</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $counter = 0; @endphp
                                        @foreach($orders as $key => $order)
                                            @php
                                                $created_at = \Carbon\Carbon::parse($order->created_at)->format('Y-m-d \a\t g:i A');
                                                $updated_at = \Carbon\Carbon::parse($order->updated_at)->format('Y-m-d \a\t g:i A');
                                            @endphp
                                            <tr>
                                                <td>{{++$counter}}</td>
                                                <td>{{$order->uuid}}</td>
                                                <td>{{$order->user->email}}</td>
                                                <td>{{$order->type}}</td>
                                                <td>{{$order->payload}}</td>
                                                <td>{{$created_at}}</td>
                                                <td>{{$updated_at}}</td>
                                                <td>
                                                    <a href="{{route('backend.order.view', ['order_uuid' =>$order->uuid])}}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <div class="horizontal-rule">
                            <hr>
                        </div>
                        <div class="d-flex justify-content-start align-items-center">
                            {{$orders->links()}}
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
