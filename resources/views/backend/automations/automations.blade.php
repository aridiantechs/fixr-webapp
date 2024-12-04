@extends('backend.layouts.app')
@section('title')
    {{ 'Fixr - Automations' }}
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
                            <h1>Automations</h1>
                            <div>
                                <a href="{{ route('backend.automation.create.view') }}" class="btn btn-primary"><i
                                        class="fas fa-plus mx-1"></i>Add Automation</a>
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
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Recurring Start Day</th>
                                            <th>Recurring End Day</th>
                                            <th>Recurring Start Time</th>
                                            <th>Recurring End Time</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $counter = 0; @endphp
                                        @foreach ($automations as $key => $automation)
                                            <tr>
                                                <td>{{ ++$counter }}</td>
                                                <td>{{ $automation->start_date_time ? format_date_time($automation->start_date_time) : 'N/A' }}
                                                </td>
                                                <td>{{ $automation->end_date_time ? format_date_time($automation->start_date_time) : 'N/A' }}
                                                </td>
                                                <td>{{ $automation->recurring_start_week_day ?? 'N/A' }}</td>
                                                <td>{{ $automation->recurring_end_week_day ?? 'N/A' }}</td>
                                                <td>{{ $automation->recurring_start_time ? format_time($automation->recurring_start_time) : 'N/A' }}
                                                </td>
                                                <td>{{ $automation->recurring_end_time ? format_time($automation->recurring_end_time) : 'N/A' }}
                                                </td>
                                                <td style="color:white">
                                                    <span
                                                        class="badge {{ $automation->is_enabled == '1' ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $automation->is_enabled == '1' ? 'enabled' : 'disabled' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a
                                                        href="{{ route('backend.automation.update.view', ['automation' => $automation]) }}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a class="mx-3"
                                                        href="{{ route('backend.automation.delete', ['automation_id' => $automation->id]) }}">
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
                            {{ $automations->links() }}
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
