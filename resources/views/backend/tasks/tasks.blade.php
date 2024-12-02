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
                        <div class="m-t-30">
                            <div class="table-responsive" id="live_tracking_table">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>type</th>
                                            <th>name</th>
                                            <th>url</th>
                                            <th>created at</th>
                                            <th>updated at</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $counter = 0; @endphp
                                        @foreach ($tasks as $key => $task)
                                            @php
                                                $created_at = format_date_time($task->created_at);
                                                $updated_at = format_date_time($task->updated_at);
                                            @endphp
                                            <tr>
                                                <td>{{ ++$counter }}</td>
                                                <td>{{ $task->type }}</td>
                                                <td>{{ $task->name }}</td>
                                                <td>{{ $task->url }}</td>
                                                <td>{{ $created_at }}</td>
                                                <td>{{ $updated_at }}</td>
                                                <td>
                                                    <a href="{{ route('backend.tasks.update.view', ['task' => $task]) }}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a class="mx-3"
                                                        href="{{ route('backend.tasks.delete', ['task_id' => $task->id]) }}">
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
                            {{ $tasks->links() }}
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
