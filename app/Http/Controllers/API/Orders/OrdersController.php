<?php

namespace App\Http\Controllers\API\Orders;

use App\Http\Controllers\Controller;
use App\Http\Resources\AutomationResource;
use App\Models\Automation;
use App\Models\PaymentCard;
use App\Models\Proxy;
use App\Models\Setting;
use App\Models\Task;
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
    public function get_card_proxy_data(Request $request)
    {
        $payment_card = PaymentCard::where('is_active', '1')->inRandomOrder()->first();
        $proxy = Proxy::all()->random();
        if (empty($payment_card)) {
            return api_response((Object) [], 400, 'No payment card found');
        }
        if (empty($proxy)) {
            return api_response((Object) [], 400, 'No proxy found');
        }
        $data = [
            'proxy' => $proxy,
            'payment_card' => $payment_card
        ];
        return api_response((Object) $data, 200);
    }
    public function get_automation_data(){
        $automation = Automation::first();
        $number_of_instances = Setting::first()->meta_value ?? '0';
        if(!$automation){
            return api_response((Object) [], 400,'No automation found');
        }
        return api_response((Object) new AutomationResource($automation, $number_of_instances), 200);
    }
    public function get_task_data(){
        $task = Task::first();
        if(!$task){
            return api_response((Object) [], 400,'No task found');
        }
        return api_response((Object)($task),200);
    }
}
