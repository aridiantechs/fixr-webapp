<?php

namespace App\Http\Controllers\API\Orders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use Illuminate\Validation\Rule;

class OrdersController extends Controller
{
    public function store(Request $request){
        $request->merge([
            "payload"=> json_encode($request->payload),
        ]);
        $validator = Validator::make($request->all(), [
            "uuid"=> "required|string",
            "type"=> [
                'required',
                'string',
                Rule::in(['checkout', 'purchased', 'cancelled'])
            ],
            "payload"=> "required|string"
        ],[
            "uuid.required"=> "Please provide uuid",
        ]);
        if($validator->fails()){
            return api_response((Object)[], 400, "validation errors", requestFormatErrors($validator->errors()));
        }
        $order = Order::create($request->all());
        if($order)
            return api_response((Object)$order, 200,"Order created successfully") ;
        return api_response((Object)[], 400,"Something went wrong...") ;
    }
    public function live_tracking(Request $request){
        $validator = Validator::make($request->all(), [
            'uuid' => 'required|string'
        ]);
        if($validator->fails()){
            return api_response((Object)[], 400,'validation error', requestFormatErrors($validator->errors())) ;
        }
        $order = Order::where('uuid', $request->uuid)->latest()->first();
        if($order)
            return api_response((Object)$order, 200);
        return api_response((Object)[], 400,'Order not found') ;
    }
}
