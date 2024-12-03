@extends('backend.layouts.app')
@section('title')
    {{ 'Fixr - Payment Cards' }}
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
    </style>
@endsection

@section('content')
    <div class="main-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1>Payment Cards</h1>
                            <div>
                                <a href="{{ route('backend.payment_card.create.view') }}" class="btn btn-primary"><i
                                        class="fas fa-plus mx-1"></i>Add Card</a>
                            </div>
                        </div>
                        <div class="mt-2 mb-2">
                            @if (session()->has('success'))
                                <div class="alert alert-success text-success">{{ session()->get('success') }}</div>
                            @endif
                        </div>
                        <div class="m-t-30">
                            <div class="table-responsive" id="live_tracking_table">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Card No.</th>
                                            <th>Expiry Month</th>
                                            <th>Expiry Year</th>
                                            <th>CVV</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $counter = 0; @endphp
                                        @foreach ($payment_cards as $key => $card)
                                            <tr>
                                                <td>{{ ++$counter }}</td>
                                                <td>{{ $card->first_name }}</td>
                                                <td>{{ $card->last_name }}</td>
                                                <td>{{ $card->card_number }}</td>
                                                <td>{{ $card->expiry_month }}</td>
                                                <td>{{ $card->expiry_year }}</td>
                                                <td>{{ $card->cvv }}</td>
                                                <td style="color:white">
                                                    <span
                                                        class="badge {{ $card->is_active == 1 ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $card->is_active == 1 ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a
                                                        href="{{ route('backend.payment_card.update.view', ['payment_card' => $card]) }}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a class="mx-3"
                                                        href="{{ route('backend.payment_card.delete', ['payment_card_id' => $card->id]) }}">
                                                        <i class="fas fa-trash-alt"></i>
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
                            {{ $payment_cards->links() }}
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
