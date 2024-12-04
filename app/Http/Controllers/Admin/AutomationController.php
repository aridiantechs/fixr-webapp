<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Automation;
use Illuminate\Http\Request;

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
            'after:recurring_start_time',
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
        $automations = Automation::orderBy("created_at", "desc")->paginate(10);
        return view("backend.automations.automations", compact("automations"));
    }
    public function show_create_form(Request $request)
    {
        return view("backend.automations.create-automation");
    }
    public function store(Request $request)
    {
        $validated_data = $request->validate($this->rules, $this->messages);

        $automation = new Automation();
        $automation->automation_type = trim($validated_data['automation_type']);

        if ($validated_data['automation_type'] === 'non_recurring') {
            $automation->start_date_time = $validated_data['start_date_time'];
            $automation->end_date_time = $validated_data['end_date_time'];
        } else {
            $automation->recurring_start_week_day = $validated_data['recurring_start_week_day'];
            $automation->recurring_end_week_day = $validated_data['recurring_end_week_day'];
            $automation->recurring_start_time = $validated_data['recurring_start_time'];
            $automation->recurring_end_time = $validated_data['recurring_end_time'];
        }
        $automation->is_enabled = $validated_data['automation_status'] === 'enabled' ? '1' : '0';

        $saved = $automation->save();
        if ($saved) {
            return back()->with('success', 'Automation successfully added');
        } else {
            return back()->with('error', 'Something went wrong...');
        }


    }
    public function show_update_form(Automation $automation, Request $request)
    {
        if (!$automation)
            abort(404);
        return view('backend.automations.update-automation', ['automation' => $automation]);
    }
    public function update(Request $request)
    {
        $validated_data = $request->validate($this->rules, $this->messages);

        $automation = Automation::find($request->automation_id);
        if (!$automation) {
            return redirect()->route('backend.automation.view')->with('error', 'Automation not found');
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

        $updated = $automation->save();

        if ($updated) {
            return redirect()->route('backend.automation.view')->with('success', 'Automation successfully updated');
        } else {
            return redirect()->route('backend.automation.view')->with('error', 'Something went wrong...');
        }
    }
    public function delete(Request $request)
    {
        $automation = Automation::find($request->automation_id);
        if (!$automation) {
            return redirect()->route('backend.automation.view')->with('error', 'Automation not found');
        }
        $deleted = $automation->delete();
        if ($deleted) {
            $key = 'success';
            $message = 'Automation successfully deleted';
        } else {
            $key = 'error';
            $message = 'Something went wrong';
        }

        return redirect()->route("backend.automation.view")->with($key, $message);

    }
}
