{{-- validation errors --}}
@if (session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
        @php session()->forget('success'); @endphp
    </div>
@endif

@if (session()->has('error'))
    <div class="alert alert-danger">
        {{ session()->get('error') }}
        @php session()->forget('error'); @endphp
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif