<table class="table table-hover">
    <thead>
        <tr class="bg-grey">
            {{-- <th class="bold">#</th> --}}
            <th>uuid</th>
            <th>user</th>
            <th>type</th>
            <th>payload</th>
            <th>created at</th>
            <th>updated at</th>
            {{-- <th>view order</th> --}}
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="6" class="p-0">
                <div class="bg-info p-1">
                    <span class="spinner-border text-danger" role="status">
                    </span>
                    <span class="mx-2" style="font-size:1.2em;">Retrieving data...</span>
                </div>
            </td>
        </tr>
        @php $counter = 0; @endphp
        @foreach ($grouped_orders as $key => $orders)
            @foreach ($orders as $order)
                @php
                    $created_at = \Carbon\Carbon::parse($order->created_at)->format('Y-m-d \a\t g:i A');
                    $updated_at = \Carbon\Carbon::parse($order->updated_at)->format('Y-m-d \a\t g:i A');
                @endphp
                <tr>
                    {{-- <td>{{++$counter}}</td> --}}
                    <td>{{ $order->uuid }}</td>
                    <td>{{ $order->user->email }}</td>
                    <td>{{ $order->type }}</td>
                    <td>
                        @php
                            $payload = is_string($order->payload) ? json_decode($order->payload) : $order->payload;
                        @endphp
                        @if (is_iterable((array)$payload))
                            @foreach ($payload as $key => $item)
                                <b>{{ $key }}: </b>{{ $item }} <br>
                            @endforeach
                        @endif
                    </td>
                    <td>{{ $created_at }}</td>
                    <td>{{ $updated_at }}</td>
                    {{-- <td>
                        <a href="{{route('backend.order.view', ['order_uuid' =>$order->uuid])}}">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td> --}}

                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
