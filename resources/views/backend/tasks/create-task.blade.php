@extends('backend.layouts.app')
@section('title')
    {{ 'Fixr - Create Task' }}
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
                            <h1>Create Task</h1>
                        </div>
                        <div class="mt-2 mb-2">
                            @if (session()->has('success'))
                                <div class="alert alert-success text-success">{{ session()->get('success') }}</div>
                            @endif
                        </div>
                        <div class="m-t-30">
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
                                        <option value="organizer" {{ old('task_type') === 'organizer' ? 'selected' : '' }}>
                                            Organizer</option>
                                    </select>
                                    @error('task_type')
                                        <div class="alert alert-danger mt-2 mb-1 text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="task_url" class="form-label">Task URL</label>
                                    <input type="text" class="form-control" id="task_url" name="task_url"
                                        aria-describedby="Task URL" value="{{ old('task_url') }}">
                                    @error('task_url')
                                        <div class="alert alert-danger mt-2 mb-1 text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">Create</button>
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
    <script></script>
@endsection
