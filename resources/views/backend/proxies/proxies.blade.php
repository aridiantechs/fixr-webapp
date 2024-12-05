@extends('backend.layouts.app')
@section('title')
    {{ 'Fixr - Proxies' }}
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
                        <h1>Create Proxy</h1>
                        <div class="mt-2 mb-2">
                            @if (session()->has('success'))
                                <div class="alert alert-success text-success">{{ session()->get('success') }}</div>
                            @endif
                        </div>
                        <div class="m-t-30">
                            <form action="{{ route('backend.proxy.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <textarea class="form-control" id="proxy_content" name="proxy_content" aria-describedby="Task Name"
                                        value="{{ old('proxy_content') }}" placeholder="Enter the proxy content here...."></textarea>
                                    @error('proxy_content')
                                        <div class="alert alert-danger mt-2 mb-1 text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Create</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1>Proxies</h1>
                        </div>
                        <div class="m-t-30">
                            <div class="table-responsive" id="live_tracking_table">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>content</th>
                                            <th>created at</th>
                                            {{-- <th>updated at</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $counter = 0; @endphp
                                        @foreach ($proxies as $key => $proxy)
                                            @php
                                                $created_at = format_date_time($proxy->created_at);
                                                $updated_at = format_date_time($proxy->updated_at);
                                            @endphp
                                            <tr>
                                                <td>{{ ++$counter }}</td>
                                                <td>{{ $proxy->content }}</td>
                                                {{-- <td>{{ $created_at }}</td> --}}
                                                <td>{{ $updated_at }}</td>
                                                <td>
                                                    <a href="{{ route('backend.proxy.update.view', ['proxy' => $proxy]) }}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a class="mx-3"
                                                        href="{{ route('backend.proxy.delete', ['proxy_id' => $proxy->id]) }}">
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
                            {{ $proxies->links() }}
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
