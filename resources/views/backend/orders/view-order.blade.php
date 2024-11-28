@extends('backend.layouts.app')
@section('title')
    {{ 'Fixr - Order Tracking' }}
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

        .container {
            margin-top: 50px;
            margin-bottom: 50px
        }

        .card {
            position: relative;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 0.10rem
        }

        .card-header:first-child {
            border-radius: calc(0.37rem - 1px) calc(0.37rem - 1px) 0 0
        }

        .card-header {
            padding: 0.75rem 1.25rem;
            margin-bottom: 0;
            background-color: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1)
        }

        .track {
            position: relative;
            background-color: #ddd;
            height: 7px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            margin-bottom: 60px;
            margin-top: 50px
        }

        .track .step {
            -webkit-box-flex: 1;
            -ms-flex-positive: 1;
            flex-grow: 1;
            width: 25%;
            margin-top: -18px;
            text-align: center;
            position: relative
        }

        .track .step.active:before {
            background: #FF5722
        }

        .track .step::before {
            height: 7px;
            position: absolute;
            content: "";
            width: 100%;
            left: 0;
            top: 18px
        }

        .track .step.active .icon {
            background: #ee5435;
            color: #fff
        }

        .track .icon {
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            position: relative;
            border-radius: 100%;
            background: #ddd
        }

        .track .step.active .text {
            font-weight: 400;
            color: #000
        }

        .track .text {
            display: block;
            margin-top: 7px
        }

        .itemside {
            position: relative;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            width: 100%
        }

        .itemside .aside {
            position: relative;
            -ms-flex-negative: 0;
            flex-shrink: 0
        }

        .img-sm {
            width: 80px;
            height: 80px;
            padding: 7px
        }

        ul.row,
        ul.row-sm {
            list-style: none;
            padding: 0
        }

        .itemside .info {
            padding-left: 15px;
            padding-right: 7px
        }

        .itemside .title {
            display: block;
            margin-bottom: 5px;
            color: #212529
        }

        p {
            margin-top: 0;
            margin-bottom: 1rem
        }

        .btn-warning {
            color: #ffffff;
            background-color: #ee5435;
            border-color: #ee5435;
            border-radius: 1px
        }

        .btn-warning:hover {
            color: #ffffff;
            background-color: #ff2b00;
            border-color: #ff2b00;
            border-radius: 1px
        }
    </style>
@endsection

@section('content')
    <div class="main-content">
        <div class="row">

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-header"> Order Tracking </h1>
                        <div class="card-body">
                            <h6><b>Order ID: {{ $order_uuid }}</b></h6>
                            <article class="card">
                                <div class="card-body row">
                                    <div class="col"> <strong>checkout time:</strong>
                                        <br>{{ isset($checkout_time) ? \Carbon\Carbon::parse($checkout_time)->format('Y-m-d g:i A') : 'N/A' }}
                                    </div>
                                    <div class="col"> <strong>Purchased by:</strong> <br> {{ $user_email }} </div>
                                    @php
                                        $statusClass = '';
                                        switch ($last_status) {
                                            case 'checkout':
                                                $statusClass = 'badge bg-warning text-dark';
                                                break;
                                            case 'purchased':
                                                $statusClass = 'badge bg-success text-white';
                                                break;
                                            case 'cancelled':
                                                $statusClass = 'badge bg-danger text-white';
                                                break;
                                            default:
                                                $statusClass = 'badge bg-secondary text-white';
                                                break;
                                        }
                                    @endphp

                                    <div class="col">
                                        <strong>Status:</strong> <br>
                                        <span class="{{ $statusClass }}">{{ $last_status }}</span>
                                    </div>

                                </div>
                            </article>
                            <div class="track">
                                @if ($checkout_time)
                                    <div class="step active"> <span class="icon"> <i class="fas fa-shopping-cart"></i>
                                        </span> <span class="text">Checkout</span>
                                    </div>
                                    @if ($purchased_time)
                                        <div class="step active"> <span class="icon"> <i class="fas fa-check-circle"></i>
                                            </span> <span class="text"> Purchased</span> </div>
                                    @elseif($cancellation_time)
                                        <div class="step active"> <span class="icon"> <i class="fas fa-times-circle"></i>
                                            </span> <span class="text"> Cancelled</span> </div>
                                    @else
                                        <div class="step"> <span class="icon"> <i class="fa fa-user"></i> </span> <span
                                                class="text"> Pending</span> </div>
                                    @endif
                                @else
                                    <div class="step"> <span class="icon"> <i class="fas fa-shopping-cart"></i>
                                        </span> <span class="text">Checkout</span>
                                    </div>
                                    <div class="step"> <span class="icon"> <i class="fa fa-user"></i> </span> <span
                                            class="text"> Pending</span> </div>
                                @endif

                            </div>
                            <hr>
                            <a href="{{ route('backend.orders') }}" class="btn btn-warning" data-abc="true"> <i
                                    class="fa fa-chevron-left"></i> Back to orders</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-zoom/0.6.6/chartjs-plugin-zoom.js"></script>
    <script></script>
@endsection
