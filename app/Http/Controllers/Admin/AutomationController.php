<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Automation;
use Illuminate\Http\Request;

class AutomationController extends Controller
{
    public function index(Request $request)
    {
        $automations = Automation::orderBy("created_at", "desc")->paginate(10);
        return view("backend.automations.automations", compact("automations"));
    }
    public function show_create_form(Request $request)
    {
        return view("backend.automations.create-automation");
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $rules = [
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
                'date_format:H:i',
            ],
            'recurring_end_time' => [
                'nullable',
                'required_if:automation_type,recurring',
                'exclude_if:automation_type,non_recurring',
                'date_format:H:i',
                'after:recurring_start_time',
            ],
        ];
        $messages = [
            'start_date_time.required_if' => 'Start date and time are required for non-recurring tasks.',
            'end_date_time.required_if' => 'End date and time are required for non-recurring tasks.',
            'recurring_start_week_day.required_if' => 'Start week day is required for recurring tasks.',
            'recurring_end_week_day.required_if' => 'End week day is required for recurring tasks.',
            'recurring_start_time.required_if' => 'Start time is required for recurring tasks.',
            'recurring_end_time.required_if' => 'End time is required for recurring tasks.',
        ];
        $validated_data = $request->validate($rules, $messages);
        


    }
    public function show_update_form(Automation $automation, Request $request)
    {

    }
    public function update(Request $request, Automation $automation)
    {

    }
    public function delete(Request $request, Automation $automation)
    {

    }
}
