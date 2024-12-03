@extends('backend.layouts.app')
@section('title')
    {{ 'Fixr - Update Proxy' }}
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
                        <h1>Update Proxy</h1>
                        <div class="mt-2 mb-2">
                            @if (session()->has('success'))
                                <div class="alert alert-success text-success">{{ session()->get('success') }}</div>
                            @endif
                        </div>
                        <div class="m-t-30">
                            <form action="{{ route('backend.proxy.update', ['proxy_id' => $proxy->id]) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <textarea class="form-control" id="proxy_content" name="proxy_content" aria-describedby="Task Name"
                                        placeholder="Enter the proxy content here....">{{ trim(old('proxy_content') ?? $proxy->content) }}</textarea>
                                    @error('proxy_content')
                                        <div class="alert alert-danger mt-2 mb-1 text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                                <button type="button" class="btn btn-secondary" id="back_btn"">Back</button>
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelector("#back_btn").onclick = function() {
                history.back();
            };
        });
    </script>
@endsection
