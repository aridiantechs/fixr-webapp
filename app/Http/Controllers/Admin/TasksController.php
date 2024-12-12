<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;



class TasksController extends Controller
{
    private $rules = [

        'task_name' => 'required|string|max:255',
        'task_type' => 'required|in:event,organizer',
        'task_url' => 'required|url',

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
        ],
        'keywords' => 'nullable|string'

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
        $tasks = Task::orderBy('created_at', 'DESC')->paginate(10);
        return view("backend.tasks.tasks", ["tasks" => $tasks]);
    }
    public function show_create_form(Request $request)
    {
        return view('backend.tasks.create-task');
    }
    public function store(Request $request)
    {
        $validator = $this->run_validations($request);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $validated_data = $validator->validated();
        $input_keywords_array = json_decode($validated_data['keywords'], true);
        $clean_keywords = [];
        if (json_last_error() === JSON_ERROR_NONE) {
            foreach ($input_keywords_array as $keyword) {
                $clean_keywords[] = $keyword['value'];
            }
        }
        $task = new Task();
        $saved = $task->store_task($validated_data, $clean_keywords);
        if(!$saved){
            return redirect()->back()->with('error', 'Something went wrong...');
        }
        return redirect()
            ->back()
            ->with('success', 'Task saved successfully!');
    }
    public function show_update_form(Request $request, Task $task)
    {
        if (!$task)
            abort(404);
        return view('backend.tasks.update-task', compact('task'));
    }
    public function update(Request $request, $task_id)
    {
        $validator = $this->run_validations($request);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $task = Task::find($task_id);
        if (!$task){
            return redirect()->back()->with('error', 'Task not found');
        }
        $validated_data = $validator->validated();
        $input_keywords_array = json_decode($validated_data['keywords'], true);
        $clean_keywords = [];
        if (json_last_error() === JSON_ERROR_NONE) {
            foreach ($input_keywords_array as $keyword) {
                $clean_keywords[] = $keyword['value'];
            }
        }
        $saved = $task->store_task($validated_data, $clean_keywords);
        if(!$saved){
            return redirect()->back()->with('error', 'Something went wrong...');
        }
        return redirect()
            ->route('backend.tasks.view')
            ->with('success', 'Task updated successfully!');

    }
    public function delete(Request $request, $task_id){
        $task = Task::find($task_id);
        if (!$task){
            return redirect()->back()->with('error', 'Task not found');
        }
        $deleted = $task->delete();
        if(!$deleted){
            return redirect()->back()->with('error', 'Error deleting the task...');
        }
        return redirect()->route('backend.tasks.view')->with('success','Task successfully deleted');
    }
    private function run_validations(Request $request)
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
        return $validator;
    }
}
