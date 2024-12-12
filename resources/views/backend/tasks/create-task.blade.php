@extends('backend.layouts.app')

@section('title')
    {{ 'Fixr - Create Task' }}
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.32.2/tagify.min.css"
        integrity="sha512-odd6lal6Yi9bIMoitKrtPFlf1eaQ+kWlW7s0tpkcGh9rsBGaS5Wb/RLGYsWZ1cbKINTNupq4UEv8rU8pXPNtBg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                            <h1>Add Task</h1>
                            <a class="btn btn-secondary" href="{{route('backend.tasks.view')}}">
                                View All
                            </a>
                        </div>
                        <div class="mt-2 mb-2">
                            @if (session()->has('success'))
                                <div class="alert alert-success text-success">{{ session()->get('success') }}</div>
                            @endif
                        </div>
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
                            <form action="{{ route('backend.tasks.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="task_name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="task_name" name="task_name"
                                        aria-describedby="Task Name" value="{{ old('task_name') }}">
                                    @error('task_name')
                                        <div class="alert alert-danger mt-2 mb-1 text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="task_type" class="form-label">Select Type</label>
                                    <select id="task_type" class="form-control" aria-label="Select Task Type"
                                        name="task_type">
                                        <option value="event" selected>Event</option>
                                        <option value="organizer" {{ old('task_type') }}>Organizer</option>
                                    </select>
                                    @error('task_type')
                                        <div class="alert alert-danger mt-2 mb-1 text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="task_url" class="form-label">Tasks URL</label>
                                    <input type="text" class="form-control" id="task_url" name="task_url"
                                        aria-describedby="Task URL" value="{{ old('task_url') }}">
                                    @error('task_url')
                                        <div class="alert alert-danger mt-2 mb-1 text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <h5>Automation Type</h5>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="automation_type"
                                                id="non_recurring" value="non_recurring" checked>
                                            <label class="form-check-label" for="non_recurring">Non-Recurring</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="automation_type"
                                                id="recurring" value="recurring"
                                                {{ old('automation_type') == 'recurring' ? 'checked' : '' }}>
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
                                            value="{{ old('start_date_time') }}">
                                        @error('start_date_time')
                                            <div class="alert alert-danger mt-2 mb-1 text-danger">{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="end_date_time" class="form-label">End Date Time</label>
                                        <input type="datetime-local" class="form-control" id="end_date_time"
                                            name="end_date_time" aria-describedby="End Date Time"
                                            value="{{ old('end_date_time') }}">
                                        @error('end_date_time')
                                            <div class="alert alert-danger mt-2 mb-1 text-danger">{{ $message }}
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
                                                    {{ old('recurring_start_week_day') === $day ? 'selected' : '' }}>
                                                    {{ ucfirst($day) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('recurring_start_week_day')
                                            <div class="alert alert-danger mt-2 mb-1 text-danger">{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="recurring_end_week_day" class="form-label">Recurring End Week
                                            Day</label>
                                        <select id="recurring_end_week_day" class="form-control"
                                            name="recurring_end_week_day">
                                            <option value="">--- Select day ---</option>
                                            @foreach ($week_days as $day)
                                                <option value="{{ $day }}"
                                                    {{ old('recurring_end_week_day') === $day ? 'selected' : '' }}>
                                                    {{ ucfirst($day) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('recurring_end_week_day')
                                            <div class="alert alert-danger mt-2 mb-1 text-danger">{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="recurring_start_time" class="form-label">Recurring Start
                                            Time</label>
                                        <input type="time" class="form-control" id="recurring_start_time"
                                            name="recurring_start_time" aria-describedby="Recurring Start Time"
                                            value="{{ old('recurring_start_time') }}">
                                        @error('recurring_start_time')
                                            <div class="alert alert-danger mt-2 mb-1 text-danger">{{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="recurring_end_time" class="form-label">Recurring End
                                            Time</label>
                                        <input type="time" class="form-control" id="recurring_end_time"
                                            name="recurring_end_time" aria-describedby="Recurring End Time"
                                            value="{{ old('recurring_end_time') }}">
                                        @error('recurring_end_time')
                                            <div class="alert alert-danger mt-2 mb-1 text-danger">{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="task_keywords" class="form-label">Keywords</label>
                                    <input type="text" class="form-control" id="task_keywords" name="keywords"
                                        aria-describedby="Task Keywords" value="{{ old('keywords') }}">
                                    <small class="text-muted">Press enter after adding a keyword</small>
                                    @error('keywords')
                                        <div class="alert alert-danger mt-2 mb-1 text-danger">{{ $message }}</div>
                                    @enderror
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
                                            id="automation_status_disabled" value="disabled">
                                        <label class="form-check-label" for="automation_status_disabled">
                                            Disabled
                                        </label>
                                    </div>
                                    @error('automation_status')
                                        <div class="alert alert-danger mt-2 mb-1 text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Submit</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.32.2/tagify.min.js"
        integrity="sha512-WyIcqrbjO2qlKYKF0w4jWyEcUC8G+ZDEjZNBDAmDTn3VI4V6zkYq81UOqIPfDVuwK2IpktSC5vVrfpD4Pp2qXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.querySelector('#task_keywords');
            // Initialize Tagify
            new Tagify(input, {
                whitelist: [], // Optional: preload some keywords
                maxTags: 20, // Limit the number of tags
                placeholder: "Add keywords...",
            });
        });
    </script>
    <script src="{{ asset('js/automation-tasks.js') }}"></script>
@endsection
