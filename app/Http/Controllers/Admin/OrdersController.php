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
        $orders = Order::where('type', 'completed')->orderBy('created_at','desc')->paginate(3);
        return view("backend.orders.orders", compact('orders'));
    }
    public function live_tracking(Request $request){
        // Get all orders (without grouping in the query)
        $all_orders = Order::all();

        // Group orders by uuid and get the latest order for each group
        $grouped_orders = $all_orders->groupBy('uuid')->map(function ($group) {
            return $group->sortByDesc('created_at')->first();
        });
        if($request->ajax()){
            return view('backend.orders.live-tracking-table-ajax', compact('grouped_orders'));
        }
        return view('backend.orders.live-tracking-orders', compact('grouped_orders'));
    }

}
