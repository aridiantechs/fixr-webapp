<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class TasksController extends Controller
{
    public function index(Request $request)
    {
        $task = Task::first();
        return view("backend.tasks.tasks", ["task" => $task]);
    }
    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'task_name' => 'required|string|max:255',
            'task_type' => 'required|in:event,organizer',
            'task_url' => 'required|url',
            'keywords' => 'nullable|string'
        ]);

        $input_keywords_array = json_decode($validated_data['keywords'], true);
        $clean_keywords = [];
        if (json_last_error() === JSON_ERROR_NONE) {
            foreach ($input_keywords_array as $keyword) {
                $clean_keywords[] = $keyword['value'];
            }
        }
        $task = Task::firstOrNew();

        $task->name = $validated_data['task_name'];
        $task->type = $validated_data['task_type'];
        $task->url = $validated_data['task_url'];
        $task->keywords = json_encode(array_unique($clean_keywords));

        $task->save();

        return redirect()
            ->back()
            ->with('success', 'Task saved successfully!');
    }
}
