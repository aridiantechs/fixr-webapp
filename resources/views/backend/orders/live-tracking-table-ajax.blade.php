<table class="table table-hover">
    <thead>
        <tr>
            <th class="bold">#</th>
            <th>uuid</th>
            <th>user</th>
            <th>type</th>
            <th>payload</th>
            <th>created at</th>
            <th>updated at</th>
            <th>view order</th>
        </tr>
    </thead>
    <tbody>
        @php $counter = 0; @endphp
        @foreach($grouped_orders as $key => $order)
            @php
                $created_at = \Carbon\Carbon::parse($order->created_at)->format('Y-m-d \a\t g:i A');
                $updated_at = \Carbon\Carbon::parse($order->updated_at)->format('Y-m-d \a\t g:i A');
            @endphp
            <tr>
                <td>{{++$counter}}</td>
                <td>{{$order->uuid}}</td>
                <td>{{$order->user->email}}</td>
                <td>{{$order->type}}</td>
                <td>{{$order->payload}}</td>
                <td>{{$created_at}}</td>
                <td>{{$updated_at}}</td>
               <td>
                    <a href="{{route('backend.order.view', ['order_uuid' =>$order->uuid])}}">
                        <i class="fas fa-eye"></i>
                    </a>
                </td>

            </tr>
        @endforeach
    </tbody>
</table>
