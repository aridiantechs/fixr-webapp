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
            "uuid" => "required|string",
            "type" => [
                'required',
                'string',
                Rule::in(['ticket','checkout', 'purchased', 'cancelled'])
            ],
            "payload" => "required|string",
            "ticket_pdf" => "required_if:type,==,purchased,mimes:pdf"
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
        
        if($request->ticket_pdf){
            $file = $request->file('ticket_pdf');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/ticket_pdf', $filename);

            $order->file = $path;
            $order->save();
        }

        if($order)
            return api_response((Object)[], 200,"Order created successfully") ;
        return api_response((Object)[], 400,"Something went wrong...") ;
    }
}
