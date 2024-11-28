<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class OrdersController extends Controller
{
    public function index(Request $request){
        $orders = Order::where('type', 'purchased')->orderBy('created_at','desc')->paginate(10);
        return view("backend.orders.orders", compact('orders'));
    }
    public function live_tracking(Request $request){
        $all_orders = Order::whereDate('created_at',now())
            ->when($request->ajax() && !is_null(request()->ref_id),function($q){
                $q->where('id','>=',request()->ref_id);
            })->get();

        $grouped_orders = $all_orders->groupBy('uuid');
        //dd($grouped_orders);
        if($request->ajax()){
            return view('backend.orders.live-tracking-table-ajax', compact('grouped_orders'));
        }
        return view('backend.orders.live-tracking-orders', compact('grouped_orders'));
    }
    public function view_order(Request $request)
    {
        $order_uuid = $request->order_uuid;

        $orders = Order::where('uuid', $order_uuid)
            /* ->where('uuid', $order_uuid)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get(); */
            ->first();

        if (!$orders || !$orders->file) {
            abort(404, 'Order not found');
        }

        $path = storage_path("app/$orders->file");

        if (!file_exists($path)) {
            abort(404, "File not found.");
        }
    
        return response()->file($path);

        $user_email = $orders->first()->user->email ?? 'N/A';

        $checkout_time = null;
        $purchased_time = null;
        $cancellation_time = null;

        foreach ($orders as $order) {
            switch ($order->type) {
                case 'checkout':
                    $checkout_time = $checkout_time ?? $order->created_at;
                    break;
                case 'purchased':
                    $purchased_time = $purchased_time ?? $order->created_at;
                    break;
                case 'cancelled':
                    $cancellation_time = $cancellation_time ?? $order->created_at;
                    break;
            }
        }
        $last_status = isset($checkout_time) ? ($orders->first()->type ?? 'N/A') :'N/A';


        return view('backend.orders.view-order', compact(
            'orders',
            'order_uuid',
            'user_email',
            'checkout_time',
            'purchased_time',
            'cancellation_time',
            'last_status'
        ));
    }


}
