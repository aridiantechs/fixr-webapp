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
        $this->validate($request, [
            "task_name" => "required",
            "task_type" => [
                "required",
                Rule::in(['event', 'organizer'])
            ],
            "task_url" => "required|url",
        ]);
        $task = new Task();
        $old_task = Task::first();
        if ($old_task) {
            $task = $old_task;
        }
        $task->name = $request->task_name;
        $task->type = $request->task_type;
        $task->url = $request->task_url;
        $task->save();

        if ($task)
            return back()->with("success", "Task successfully created");
        return back()->with("error", "Error creating the new task")->withInput(request()->all());
    }
}
