@extends('backend.layouts.app')
@section('title')
    {{ 'Fixr - Tasks' }}
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
                            <h1>Tasks</h1>
                            <div>
                                <a href="{{ route('backend.tasks.create.view') }}" class="btn btn-primary"><i
                                        class="fas fa-plus mx-1"></i>Add Task</a>
                            </div>
                        </div>
                        <div class="mt-2 mb-2">
                            @if (session()->has('success'))
                                <div class="alert alert-success text-success">{{ session()->get('success') }}</div>
                            @endif
                        </div>
                        <hr>
                        <div class="m-t-30">
                            <div class="table-responsive" id="live_tracking_table">
                                @if (!empty($tasks))
                                    <table class="table table-hover">
                                        <thead>
                                            <tr class="bg-grey">
                                                <th>Type</th>
                                                <th>Name</th>
                                                <th>URL</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Recurring Start Day</th>
                                                <th>Recurring End Day</th>
                                                <th>Recurring Start Time</th>
                                                <th>Recurring End Time</th>
                                                <th>Keywords</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                                {{-- <th>Created at</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($tasks as $task)
                                                @php
                                                    $created_at = isset($task->created_at)
                                                        ? format_date_time($task->created_at)
                                                        : 'N/A';

                                                @endphp
                                                <tr>
                                                    <td>{{ $task->type ?? 'N/A' }}</td>
                                                    <td>{{ $task->name ?? 'N/A' }}</td>
                                                    <td
                                                        style="max-width: 200px; word-wrap: break-word; white-space: normal;">
                                                        {{ $task->url ?? 'N/A' }}</td>
                                                    <td>{{ isset($task->start_date_time) ? format_date_time($task->start_date_time) : 'N/A' }}
                                                    </td>
                                                    <td>{{ isset($task->end_date_time) ? format_date_time($task->end_date_time) : 'N/A' }}
                                                    </td>
                                                    <td>{{ $task->recurring_start_week_day ?? 'N/A' }}</td>
                                                    <td>{{ $task->recurring_end_week_day ?? 'N/A' }}</td>
                                                    <td>{{ isset($task->recurring_start_time) ? format_time($task->recurring_start_time) : 'N/A' }}
                                                    </td>
                                                    <td>{{ isset($task->recurring_end_time) ? format_time($task->recurring_end_time) : 'N/A' }}
                                                    </td>
                                                    <td
                                                        style="max-width: 250px; word-wrap: break-word; white-space: normal;">
                                                        @if ($task->keywords)
                                                            @foreach (json_decode($task->keywords, true) as $keyword)
                                                                <span class="badge bg-info"
                                                                    style="display: inline-block; margin-bottom: 5px;margin-left:3px; margin-right:3px;">{{ $keyword }}</span>
                                                            @endforeach
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>

                                                    <td style="color:white">
                                                        <span
                                                            class="badge
                                                        {{ isset($task->is_enabled) ? ($task->is_enabled == '1' ? 'bg-success' : 'bg-danger') : 'bg-secondary' }}">
                                                            {{ isset($task->is_enabled) ? ($task->is_enabled == '1' ? 'enabled' : 'disabled') : 'N/A' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a
                                                            href="{{ route('backend.tasks.update.view', ['task' => $task]) }}">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a class="mx-1"
                                                            href="{{ route('backend.tasks.delete', ['task_id' => $task->id]) }}">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </a>

                                                    </td>
                                                    {{-- <td>{{ $created_at }}</td> --}}

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div class="d-flex justify-content-center align-items-center" style="height:500px;">
                                        <h1 class="text-secondary text-bold"><span class="mx-2"><i
                                                    class="fas fa-exclamation-triangle"></i></span>No Task Found
                                        </h1>
                                    </div>
                                @endif
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
@endsection
