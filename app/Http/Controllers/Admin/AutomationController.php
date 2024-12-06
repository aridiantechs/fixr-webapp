<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Automation;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AutomationController extends Controller
{
    private $rules = [
        'automation_type' => ['required', 'in:non_recurring,recurring'],

        // Non-Recurring Validation
        'start_date_time' => [
            'nullable',
            'required_if:automation_type,non_recurring',
            'exclude_if:automation_type,recurring',
            'date',
        ],
        'end_date_time' => [
            'nullable',
            'required_if:automation_type,non_recurring',
            'exclude_if:automation_type,recurring',
            'date',
            'after_or_equal:start_date_time',
        ],

        // Recurring Validation
        'recurring_start_week_day' => [
            'nullable',
            'required_if:automation_type,recurring',
            'exclude_if:automation_type,non_recurring',
            'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
        ],
        'recurring_end_week_day' => [
            'nullable',
            'required_if:automation_type,recurring',
            'exclude_if:automation_type,non_recurring',
            'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
        ],
        'recurring_start_time' => [
            'nullable',
            'required_if:automation_type,recurring',
            'exclude_if:automation_type,non_recurring',
        ],
        'recurring_end_time' => [
            'nullable',
            'required_if:automation_type,recurring',
            'exclude_if:automation_type,non_recurring',
        ],
        'automation_status' => [
            'required',
            'in:enabled,disabled'
        ]
    ];
    private $messages = [
        'start_date_time.required_if' => 'Start date and time are required for non-recurring tasks.',
        'end_date_time.required_if' => 'End date and time are required for non-recurring tasks.',
        'recurring_start_week_day.required_if' => 'Start week day is required for recurring tasks.',
        'recurring_end_week_day.required_if' => 'End week day is required for recurring tasks.',
        'recurring_start_time.required_if' => 'Start time is required for recurring tasks.',
        'recurring_end_time.required_if' => 'End time is required for recurring tasks.',
    ];
    public function index(Request $request)
    {
        $automation = Automation::first();
        $setting = Setting::first();
        return view("backend.automations.automations", compact("automation", "setting"));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules);

        $validator->after(function ($validator) use ($request) {
            if ($request->automation_type === 'recurring') {
                // Check if start and end weekdays are the same
                if (
                    $request->recurring_start_week_day === $request->recurring_end_week_day &&
                    $request->recurring_start_time === $request->recurring_end_time
                ) {
                    $validator->errors()->add(
                        'recurring_end_time',
                        'The recurring end time must be different from the recurring start time when weekdays are the same.'
                    );
                }

                // Check if end time is greater than start time
                if (
                    $request->recurring_start_week_day === $request->recurring_end_week_day &&
                    $request->recurring_start_time >= $request->recurring_end_time
                ) {
                    $validator->errors()->add(
                        'recurring_end_time',
                        'The recurring end time must be greater than the recurring start time when the weekdays are the same.'
                    );
                }
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $validated_data = $validator->validated();
        $automation = new Automation();
        $old_automation = Automation::first();
        if ($old_automation) {
            $automation = $old_automation;
        }
        $automation->automation_type = trim($validated_data['automation_type']);

        if ($validated_data['automation_type'] === 'non_recurring') {

            $automation->start_date_time = $validated_data['start_date_time'];
            $automation->end_date_time = $validated_data['end_date_time'];

            $automation->recurring_start_week_day = null;
            $automation->recurring_end_week_day = null;
            $automation->recurring_start_time = null;
            $automation->recurring_end_time = null;

        } else {

            $automation->recurring_start_week_day = $validated_data['recurring_start_week_day'];
            $automation->recurring_end_week_day = $validated_data['recurring_end_week_day'];
            $automation->recurring_start_time = $validated_data['recurring_start_time'];
            $automation->recurring_end_time = $validated_data['recurring_end_time'];

            $automation->start_date_time = null;
            $automation->end_date_time = null;
        }
        $automation->is_enabled = $validated_data['automation_status'] === 'enabled' ? '1' : '0';

        $saved = $automation->save();
        if ($saved) {
            return back()->with('success', 'Automation successfully added');
        } else {
            return back()->with('error', 'Something went wrong...');
        }

    }
    public function  store_setting(Request $request){
        $request->validate([
            'number_of_instances'=> 'required|numeric|min:0|max:50',
        ],[
        ], [
            'number_of_instances'=> 'number of instances'
        ]);
        $setting = Setting::firstOrNew();
        $setting->meta_key = 'number_of_instances';
        $setting->meta_value = $request->number_of_instances;

        $saved = $setting->save();
        if ($saved) {
            return back()->with('setting_success','Setting saved...');
        }
        return back()->with('error','Something went wrong');
    }
}
