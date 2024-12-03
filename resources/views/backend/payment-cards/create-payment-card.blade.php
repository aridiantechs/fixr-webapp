@extends('backend.layouts.app')
@section('title')
    {{ 'Fixr - Create Card' }}
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
                            <h1>Create Card</h1>
                        </div>
                        <div class="mt-2 mb-2">
                            @if (session()->has('success'))
                                <div class="alert alert-success text-success">{{ session()->get('success') }}</div>
                            @endif
                        </div>
                        <div class="m-t-30">
                            <form action="{{ route('backend.payment_card.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="task_name" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name"
                                        aria-describedby="First Name" value="{{ old('first_name') }}">
                                    @error('first_name')
                                        <div class="alert alert-danger mt-2 mb-1 text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name"
                                        aria-describedby="Last Name" value="{{ old('last_name') }}">
                                    @error('last_name')
                                        <div class="alert alert-danger mt-2 mb-1 text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="card_number" class="form-label">Card Number</label>
                                    <input type="text" class="form-control" id="card_number" name="card_number"
                                        aria-describedby="Card Number" value="{{ old('card_number') }}">
                                    @error('card_number')
                                        <div class="alert alert-danger mt-2 mb-1 text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="expiry_month" class="form-label">Expiry Month</label>
                                    <input type="text" class="form-control" id="expiry_month" name="expiry_month"
                                        aria-describedby="Expiry Month" value="{{ old('expiry_month') }}">
                                    @error('expiry_month')
                                        <div class="alert alert-danger mt-2 mb-1 text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="expiry_year" class="form-label">Expiry Year</label>
                                    <input type="text" class="form-control" id="expiry_year" name="expiry_year"
                                        aria-describedby="Expiry Year" value="{{ old('expiry_year') }}">
                                    @error('expiry_year')
                                        <div class="alert alert-danger mt-2 mb-1 text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="expiry_year" class="form-label">CVV</label>
                                    <input type="text" class="form-control" id="cvv" name="cvv"
                                        aria-describedby="CVV" value="{{ old('cvv') }}">
                                    @error('cvv')
                                        <div class="alert alert-danger mt-2 mb-1 text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mt-2 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="card_status"
                                            id="card_status_active" value="active" checked>
                                        <label class="form-check-label" for="card_status_active">
                                            Active
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="card_status"
                                            id="card_status_inactive" value="inactive">
                                        <label class="form-check-label" for="card_status_inactive">
                                            Inactive
                                        </label>
                                    </div>
                                    @error('card_status')
                                        <div class="alert alert-danger mt-2 mb-1 text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('backend.payment_card.view') }}" class="btn btn-secondary mx-2">
                                        Back
                                    </a>
                                    <button type="submit" class="btn btn-primary">Create</button>
                                </div>
                            </form>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-zoom/0.6.6/chartjs-plugin-zoom.js"></script>
@endsection
