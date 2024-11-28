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
        $request->merge([
            'user_id' => auth()->user()->id
        ]);
        $order = Order::create($request->all());
        if($order)
            return api_response((Object)[], 200,"Order created successfully") ;
        return api_response((Object)[], 400,"Something went wrong...") ;
    }
}
