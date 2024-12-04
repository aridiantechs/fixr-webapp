<?php

namespace App\Http\Controllers\API\Orders;

use App\Http\Controllers\Controller;
use App\Models\PaymentCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use Illuminate\Validation\Rule;

class OrdersController extends Controller
{
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "uuid" => "required|string",
            "type" => [
                'required',
                'string',
                Rule::in(['ticket', 'checkout', 'purchased', 'cancelled'])
            ],
            "payload" => "required|string",
            "ticket_pdf" => "required_if:type,==,purchased,mimes:pdf"
        ], [
            "uuid.required" => "Please provide uuid",
        ]);
        if ($validator->fails()) {
            return api_response((Object) [], 400, "validation errors", requestFormatErrors($validator->errors()));
        }
        $request->merge([
            'user_id' => auth()->user()->id
        ]);
        $order = Order::create($request->all());

        if ($request->ticket_pdf) {
            $file = $request->file('ticket_pdf');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/ticket_pdf', $filename);

            $order->file = $path;
            $order->save();
        }

        if ($order)
            return api_response((Object) [], 200, "Order created successfully");
        return api_response((Object) [], 400, "Something went wrong...");
    }
    public function get_task_data(Request $request)
    {
        $file_path = public_path('JSON/random-names.json');
        if (!file_exists($file_path)) {
            return api_response((Object) [], 400, 'File does not exist');
        }
        $json_content = file_get_contents($file_path);
        $namesArray = json_decode($json_content, true);

        if (empty($namesArray)) {
            return api_response((Object) [], 400, 'File is empty');
        }
        $random_name = $namesArray[array_rand($namesArray)];
        $payment_card = PaymentCard::where('is_active', '1')->inRandomOrder()->first();
        if (empty($payment_card)) {
            return api_response((Object) [], 400, 'No payment card found');
        }
        $data = [
            'random_name' => $random_name,
            'payment_card' => $payment_card
        ];
        return api_response((Object) $data, 200);
    }
}
