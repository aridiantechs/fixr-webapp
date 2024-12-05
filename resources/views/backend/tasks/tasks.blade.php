@extends('backend.layouts.app')
@section('title')
    {{ 'Fixr - Tasks' }}
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css">
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
                            <h1>Task</h1>
                        </div>
                        <div class="m-t-30">
                            <form action="{{ route('backend.tasks.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="task_name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="task_name" name="task_name"
                                        aria-describedby="Task Name" value="{{ old('task_name') ?? $task->name }}">
                                    @error('task_name')
                                        <div class="alert alert-danger mt-2 mb-1 text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="task_type" class="form-label">Select Type</label>
                                    <select id="task_type" class="form-control" aria-label="Select Task Type"
                                        name="task_type">
                                        <option value="event" selected>Event</option>
                                        <option value="organizer"
                                            {{ old('task_type') || $task->type === 'organizer' ? 'selected' : '' }}>
                                            Organizer</option>
                                    </select>
                                    @error('task_type')
                                        <div class="alert alert-danger mt-2 mb-1 text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="task_url" class="form-label">Task URL</label>
                                    <input type="text" class="form-control" id="task_url" name="task_url"
                                        aria-describedby="Task URL" value="{{ old('task_url') ?? $task->url }}">
                                    @error('task_url')
                                        <div class="alert alert-danger mt-2 mb-1 text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="task_keywords" class="form-label">Keywords</label>
                                    <input type="text" class="form-control" id="task_keywords" name="keywords"
                                        aria-describedby="Task Keywords"
                                        value="{{ old('keywords') ?? json_encode($task->keywords ? json_decode($task->keywords) : []) }}">

                                    <small class="text-muted">Press enter after adding a keyword</small>
                                    @error('keywords')
                                        <div class="alert alert-danger mt-2 mb-1 text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>

                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-t-30">
                            <div class="table-responsive" id="live_tracking_table">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>type</th>
                                            <th>name</th>
                                            <th>url</th>
                                            <th>Keywords</th>
                                            <th>created at</th>
                                            <th>updated at</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $created_at = isset($task->created_at)
                                                ? format_date_time($task->created_at)
                                                : 'N/A';
                                            $updated_at = isset($task->updated_at)
                                                ? format_date_time($task->updated_at)
                                                : 'N/A';
                                        @endphp
                                        <tr>
                                            <td>{{ $task->type ?? 'N/A' }}</td>
                                            <td>{{ $task->name ?? 'N/A' }}</td>
                                            <td>{{ $task->url ?? 'N/A' }}</td>
                                            <td>
                                                @if ($task->keywords)
                                                    @foreach (json_decode($task->keywords, true) as $keyword)
                                                        <span class="badge bg-info">{{ $keyword }}</span>
                                                    @endforeach
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>{{ $created_at }}</td>
                                            <td>{{ $updated_at }}</td>

                                        </tr>
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
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.querySelector('#task_keywords');

            // Initialize Tagify
            const tagify = new Tagify(input, {
                whitelist: [], // Optional: preload some keywords
                maxTags: 20, // Limit the number of tags
                placeholder: "Add keywords...",
            });
        });
    </script>
@endsection
