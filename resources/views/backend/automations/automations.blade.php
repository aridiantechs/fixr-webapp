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
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mt-3 mb-2">
                                <h1>Settings</h1>
                                <span class="text-secondary">
                                    Set the settings for the automation here
                                </span>
                                <div class="mt-2 mb-2">
                                    @if (session()->has('setting_success'))
                                        <div class="alert alert-success text-success">
                                            {{ session()->get('setting_success') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card ">
                                <div class="card-body">
                                    <div class="m-t-30">
                                        <form action="{{ route('backend.setting.store.setting') }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between">
                                                    <label for="automation_setting" class="form-label">No. of Instances
                                                    </label>
                                                    <small class="text-info mx-2"><b>max allowed : 50</b></small>
                                                </div>

                                                <input type="number" min="0" max="50" class="form-control"
                                                    id="number_of_instances" name="number_of_instances"
                                                    aria-describedby="Number of instances"
                                                    value="{{ old('number_of_instances', isset($setting->meta_value) ? $setting->meta_value : '') }}">
                                                <small class="text-secondary">Current instances
                                                    : <b>{{ isset($setting->meta_value) ? $setting->meta_value : ' 0' }}</b></small>

                                                @error('number_of_instances')
                                                    <div class="alert alert-danger mt-2 mb-1 text-danger">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="d-flex justify-content-end mt-4">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr style="width:100%;">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mt-3 mb-2">
                                <h1>Automations</h1>
                                <p class="text-secondary">
                                    Set the automation here
                                </p>
                                <div class="mt-2 mb-2">
                                    @if (session()->has('success'))
                                        <div class="alert alert-success text-success">{{ session()->get('success') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card p-3">
                                <div class="card-body">
                                    <div class="m-t-30">
                                        @php
                                            $week_days = [
                                                'monday',
                                                'tuesday',
                                                'wednesday',
                                                'thursday',
                                                'friday',
                                                'saturday',
                                                'sunday',
                                            ];
                                        @endphp
                                        <form action="{{ route('backend.setting.store.automation') }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <h5>Automation Type</h5>
                                                <div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="automation_type"
                                                            id="non_recurring" value="non_recurring" checked>
                                                        <label class="form-check-label"
                                                            for="non_recurring">Non-Recurring</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="automation_type"
                                                            id="recurring" value="recurring"
                                                            {{ old('automation_type') || $automation->automation_type == 'recurring' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="recurring">Recurring</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Non-Recurring Fields -->
                                            <div id="non_recurring_task_fields_container">
                                                <div class="mb-3">
                                                    <label for="start_date_time" class="form-label">Start Date Time</label>
                                                    <input type="datetime-local" class="form-control" id="start_date_time"
                                                        name="start_date_time" aria-describedby="Start Date Time"
                                                        value="{{ old('start_date_time', $automation->start_date_time ? $automation->start_date_time : '') }}">
                                                    @error('start_date_time')
                                                        <div class="alert alert-danger mt-2 mb-1 text-danger">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror

                                                </div>
                                                <div class="mb-3">
                                                    <label for="end_date_time" class="form-label">End Date Time</label>
                                                    <input type="datetime-local" class="form-control" id="end_date_time"
                                                        name="end_date_time" aria-describedby="End Date Time"
                                                        value="{{ old('end_date_time', $automation->end_date_time ? $automation->end_date_time : '') }}">
                                                    @error('end_date_time')
                                                        <div class="alert alert-danger mt-2 mb-1 text-danger">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Recurring Fields -->
                                            <div id="recurring_task_fields_container" class="d-none">
                                                <div class="mb-3">
                                                    <label for="recurring_start_week_day" class="form-label">Recurring Start
                                                        Week Day</label>
                                                    <select id="recurring_start_week_day" class="form-control"
                                                        name="recurring_start_week_day">
                                                        <option value="">--- Select day ---</option>
                                                        @foreach ($week_days as $day)
                                                            <option value="{{ $day }}"
                                                                {{ old('recurring_start_week_day') || $automation->recurring_start_week_day == $day ? 'selected' : '' }}>
                                                                {{ ucfirst($day) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('recurring_start_week_day')
                                                        <div class="alert alert-danger mt-2 mb-1 text-danger">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="recurring_end_week_day" class="form-label">Recurring End
                                                        Week
                                                        Day</label>
                                                    <select id="recurring_end_week_day" class="form-control"
                                                        name="recurring_end_week_day">
                                                        <option value="">--- Select day ---</option>
                                                        @foreach ($week_days as $day)
                                                            <option value="{{ $day }}"
                                                                {{ old('recurring_end_week_day') || $automation->recurring_end_week_day === $day ? 'selected' : '' }}>
                                                                {{ ucfirst($day) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('recurring_end_week_day')
                                                        <div class="alert alert-danger mt-2 mb-1 text-danger">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="recurring_start_time" class="form-label">Recurring Start
                                                        Time</label>
                                                    <input type="time" class="form-control" id="recurring_start_time"
                                                        name="recurring_start_time" aria-describedby="Recurring Start Time"
                                                        value="{{ old('recurring_start_time', $automation->recurring_start_time ? $automation->recurring_start_time : '') }}">
                                                    @error('recurring_start_time')
                                                        <div class="alert alert-danger mt-2 mb-1 text-danger">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="recurring_end_time" class="form-label">Recurring End
                                                        Time</label>
                                                    <input type="time" class="form-control" id="recurring_end_time"
                                                        name="recurring_end_time" aria-describedby="Recurring End Time"
                                                        value="{{ old('recurring_end_time', $automation->recurring_end_time ? $automation->recurring_end_time : '') }}">
                                                    @error('recurring_end_time')
                                                        <div class="alert alert-danger mt-2 mb-1 text-danger">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="mt-2 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="automation_status"
                                                        id="automation_status_enabled" value="enabled" checked>
                                                    <label class="form-check-label" for="automation_status_enabled">
                                                        Enabled
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="automation_status"
                                                        id="automation_status_disabled" value="disabled"
                                                        {{ old('automation_status') === 'disabled' || $automation->is_enabled == '0' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="automation_status_disabled">
                                                        Disabled
                                                    </label>
                                                </div>
                                                @error('automation_status')
                                                    <div class="alert alert-danger mt-2 mb-1 text-danger">{{ $message }}
                                                    </div>
                                                @enderror
                                            </div>


                                            <div class="d-flex justify-content-end mt-3">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                {{-- <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="m-t-30">
                                <div class="table-responsive" id="live_tracking_table">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Recurring Start Day</th>
                                                <th>Recurring End Day</th>
                                                <th>Recurring Start Time</th>
                                                <th>Recurring End Time</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ isset($automation->start_date_time) ? format_date_time($automation->start_date_time) : 'N/A' }}
                                                </td>
                                                <td>{{ isset($automation->end_date_time) ? format_date_time($automation->end_date_time) : 'N/A' }}
                                                </td>
                                                <td>{{ $automation->recurring_start_week_day ?? 'N/A' }}</td>
                                                <td>{{ $automation->recurring_end_week_day ?? 'N/A' }}</td>
                                                <td>{{ isset($automation->recurring_start_time) ? format_time($automation->recurring_start_time) : 'N/A' }}
                                                </td>
                                                <td>{{ isset($automation->recurring_end_time) ? format_time($automation->recurring_end_time) : 'N/A' }}
                                                </td>
                                                <td style="color:white">
                                                    <span
                                                        class="badge
                                                        {{ isset($automation->is_enabled)
                                                            ? ($automation->is_enabled == '1'
                                                                ? 'bg-success'
                                                                : 'bg-danger')
                                                            : 'bg-secondary' }}">
                                                        {{ isset($automation->is_enabled) ? ($automation->is_enabled == '1' ? 'enabled' : 'disabled') : 'N/A' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>

                        </div>
                    </div>
                </div> --}}

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-zoom/0.6.6/chartjs-plugin-zoom.js"></script>
    <script src="{{ asset('js/automation-tasks.js') }}"></script>
@endsection
