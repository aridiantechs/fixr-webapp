<?php

namespace App\Http\Controllers\API\Orders;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskCollection;
use App\Models\Automation;
use App\Models\PaymentCard;
use App\Models\Proxy;
use App\Models\Setting;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;

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
    public function get_automation_data()
    {
        date_default_timezone_set('Asia/Karachi');
        $tasks = Task::latest()
            ->where('is_enabled', '1')
            ->get()
            ->filter(function ($task) {
                if ($task->automation_type == 'non_recurring') {
                    // Parse the start and end date-times
                    $start_date_time = Carbon::parse($task->start_date_time);
                    $end_date_time = Carbon::parse($task->end_date_time);

                    // Check if the current time is within the start and end range
                    return $start_date_time <= now() && now() < $end_date_time;
                } else {
                    // Get current day and time
                    $currentDay = strtolower(now()->format('l')); // Current weekday as a string, e.g. 'Friday'
                    $currentTime = now()->format('H:i'); // Current time in 24-hour format, e.g. '01:30'

                    // Task's recurring week days
                    $startWeekDay = strtolower($task->recurring_start_week_day); // Task start day of the week
                    $endWeekDay = strtolower($task->recurring_end_week_day); // Task end day of the week
                    $startTime = Carbon::parse($task->recurring_start_time)->format('H:i'); // Task start time in 24-hour format
                    $endTime = Carbon::parse($task->recurring_end_time)->format('H:i'); // Task end time in 24-hour format

                    // Map of weekdays to ensure proper comparison
                    $daysMap = [
                        'sunday' => 0,
                        'monday' => 1,
                        'tuesday' => 2,
                        'wednesday' => 3,
                        'thursday' => 4,
                        'friday' => 5,
                        'saturday' => 6,
                    ];

                    // Convert weekdays to numeric values
                    $currentDayNumber = $daysMap[$currentDay];
                    $startWeekDayNumber = $daysMap[$startWeekDay];
                    $endWeekDayNumber = $daysMap[$endWeekDay];




                    if ($startWeekDayNumber <= $currentDayNumber && $currentDayNumber <= $endWeekDayNumber) {

                        if ($startWeekDayNumber == $endWeekDayNumber && $startWeekDayNumber == $currentDayNumber)
                            return $currentTime >= $startTime && $currentTime <= $endTime;

                        if ($startWeekDayNumber == $currentDayNumber && $currentDayNumber < $endWeekDayNumber)
                            return $currentTime >= $startTime;

                        if ($currentDayNumber == $endWeekDayNumber && $currentDayNumber > $startWeekDayNumber)
                            return $currentTime <= $endTime;

                        return true;
                    }

                    // Handle wrap-around case where start day is later in the week than the end day (e.g. Friday to Monday)
                    if ($startWeekDayNumber > $endWeekDayNumber) {

                        if ($startWeekDayNumber == $currentDayNumber && $currentDayNumber < $endWeekDayNumber)
                            return $currentTime >= $startTime;

                        if ($currentDayNumber == $endWeekDayNumber && $currentDayNumber > $startWeekDayNumber)
                            return $currentTime <= $endTime;

                        return true;
                    }
                    return false;
                }
            });
        $global_setting = Setting::first();
        $number_of_instances = $global_setting->meta_value ?? '0';
        $monitoring_status = isset($global_setting->monitoring_status) && $global_setting->monitoring_status == '1' ? 'enabled' : 'disabled';
        if (!$tasks) {
            return api_response((Object) [], 400, 'No task found');
        }
        return api_response((Object) new TaskCollection($tasks, $number_of_instances, $monitoring_status), 200);
    }
    public function get_task_data()
    {
        $task = Task::first();
        if (!$task) {
            return api_response((Object) [], 400, 'No task found');
        }
        return api_response((Object) ($task), 200);
    }
}
