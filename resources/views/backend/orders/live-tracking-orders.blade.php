@extends('backend.layouts.app')
@section('title')
    {{ 'Fixr - Live Tracking' }}
@endsection
@section('styles')
    <style>
        .stats-icon {
            font-size: 27px;
            color: #66554b;
        }

        .stats-val {
            color: #e31c79;
        }

        .bg-grey {
            background: #f2f2f2;
        }

        .bg-info {
            border: 1px solid;
            border-color: rgb(70, 147, 255) !important;
            background-color: rgb(236, 244, 255) !important;
        }

        .spinner-border {
            width: 1.5rem;
            height: 1.5rem;
        }

        .custom-icon-class::before {
            content: '\f07a';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            margin-right: 8px;
            color: #149719;
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
                                        <span class="badge badge-warning badge-dot m-{{ $alignShort }}-10"></span>
                                        <span>New</span>
                                    </p>
                                    <h5 class="m-b-0">350</h5>
                                </div>
                                <div class="d-flex justify-content-between align-items-center m-b-20">
                                    <p class="m-b-0 d-flex align-items-center">
                                        <span class="badge badge-primary badge-dot m-{{ $alignShort }}-10"></span>
                                        <span>Pending</span>
                                    </p>
                                    <h5 class="m-b-0">450</h5>
                                </div>
                                <div class="d-flex justify-content-between align-items-center m-b-20">
                                    <p class="m-b-0 d-flex align-items-center">
                                        <span class="badge badge-danger badge-dot m-{{ $alignShort }}-10"></span>
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
                            <h1 class="d-inline-block">Live Tracking</h1>
                            {{--  <span class="mx-2" id="spinner"></span> --}}
                            {{-- <div>
                                <a href="javascript:void(0);" class="btn btn-sm btn-default">View All</a>
                            </div> --}}
                        </div>
                        <div class="m-t-30">
                            <div class="table-responsive" id="live_tracking_table">
                                <table class="table table-hover" id="orders_table">
                                    <thead>
                                        <tr class="bg-grey">
                                            {{-- <th class="bold">#</th> --}}
                                            <th>uuid</th>
                                            <th>user</th>
                                            <th>type</th>
                                            <th>payload</th>
                                            <th>created at</th>
                                            <th>updated at</th>
                                            {{-- <th>view order</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody id="live_tracking_table_body">
                                        <tr>
                                            <td colspan="6" class="p-0">
                                                <div class="bg-info p-1">
                                                    <span class="spinner-border text-danger" role="status">
                                                    </span>
                                                    <span class="mx-2" style="font-size:1.2em;">Retrieving data...</span>
                                                </div>
                                            </td>
                                        </tr>
                                        @php
                                            $counter = 0;
                                            $ref_id = count($grouped_orders)
                                                ? $grouped_orders->first()->first()->id
                                                : null;
                                        @endphp
                                        @foreach ($grouped_orders as $key => $orders)
                                            @foreach ($orders as $order)
                                                @php
                                                    $created_at = \Carbon\Carbon::parse($order->created_at)->format(
                                                        'Y-m-d \a\t g:i A',
                                                    );
                                                    $updated_at = \Carbon\Carbon::parse($order->updated_at)->format(
                                                        'Y-m-d \a\t g:i A',
                                                    );
                                                @endphp
                                                <tr>
                                                    <td>{{ $order->uuid }}</td>
                                                    <td>{{ $order->user->email }}</td>
                                                    <td>{{ $order->type }}</td>
                                                    <td>
                                                        @php
                                                            $payload = is_string($order->payload)
                                                                ? json_decode($order->payload)
                                                                : $order->payload;
                                                        @endphp
                                                        @if (is_iterable($payload))
                                                            @foreach ($payload as $key => $item)
                                                                <b>{{ $key }}: </b>{{ $item }} <br>
                                                            @endforeach
                                                        @else
                                                            {{ $payload }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $created_at }}</td>
                                                    <td>{{ $updated_at }}</td>
                                                    {{-- <td>
                                                        <a href="{{route('backend.order.view', ['order_uuid' =>$order->uuid])}}">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </td> --}}

                                                </tr>
                                            @endforeach
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    <script>
        $(document).ready(function() {
            toastr.options = {
                closeButton: true, // Adds a close button
                progressBar: true, // Shows a progress bar
                positionClass: 'toast-top-right', // Position of the toast
                timeOut: 3000, // Duration in milliseconds
                extendedTimeOut: 1000,
                iconClass: 'toast-info',
                toastClass: 'toast',
                // Custom class for the icon
            };

            setInterval(() => {
                let old_table_rows_count = $('#live_tracking_table_body tr').length;
                $.ajax({
                    url: "{{ route('backend.orders.liveTracking') }}",
                    type: "GET",
                    dataType: "html",
                    data: {
                        'ref_id': '{{ $ref_id }}'
                    },
                    beforeSend: function() {
                        $("#spinner").html(`
                            <span class="spinner-border text-danger" role="status">
                            </span>
                            <span class="mx-2" style="font-size:1.2em;">Retrieving data...</span>
                    `);
                    },
                    success: function(response, status, xhr) {
                        setTimeout(() => {
                            $("#spinner").html("");
                            $("#live_tracking_table_body").html(response);
                            let current_rows_count = $("#live_tracking_table_body tr")
                                .length;
                            if (current_rows_count > old_table_rows_count) {
                                toastr.info('New order added successfully!',
                                    'Success');
                            }
                        }, 1200);
                    },
                    error: function(xhr, status, response) {
                        console.log(status, response);

                        $("#spinner").html("");
                        $("#live_tracking_table").html(`
                    <div class="d-flex justify-content-center align-items-center" style="height:500px;">
                            <h1 class="text-danger text-bold"><span class="mx-2"><i class="fas fa-exclamation-triangle"></i></span>Error occurred</h1>
                    </div>`);
                    }
                });
            }, 10000);
        });
    </script>
@endsection
