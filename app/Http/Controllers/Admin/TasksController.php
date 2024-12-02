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
        $tasks = Task::orderBy("created_at", "desc")->paginate(10);
        return view("backend.tasks.tasks", ["tasks" => $tasks]);
    }
    public function show_create_form(Request $request)
    {
        return view("backend.tasks.create-task");
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
        $task->name = $request->task_name;
        $task->type = $request->task_type;
        $task->url = $request->task_url;
        $task->save();

        if ($task)
            return back()->with("success", "Task successfully created");
        return back()->with("error", "Error creating the new task")->withInput(request()->all());
    }
    public function show_update_form(Task $task, Request $request)
    {
        if (!$task)
            abort(404);
        return view("backend.tasks.update-task", ['task' => $task]);
    }
    public function update(Request $request)
    {
        $this->validate($request, [
            "task_name" => "required",
            "task_type" => [
                "required",
                Rule::in(['event', 'organizer'])
            ],
            "task_url" => "required|url",
        ]);
        $task = Task::find($request->task_id);
        if (!$task)
            abort(404);
        $task->name = $request->task_name;
        $task->type = $request->task_type;
        $task->url = $request->task_url;
        $task->save();

        if ($task)
            return redirect()->route('backend.tasks.view')->with("success", "Task successfully updated");
        return back()->with("error", "Error creating the new task")->withInput(request()->all());

    }
    public function delete(Request $request)
    {
        $task = Task::find($request->task_id);
        if (!$task)
            abort(404);
        $deleted = $task->delete();
        if ($deleted) {
            $key = 'success';
            $message = 'Task successfully deleted';
        } else {
            $key = 'error';
            $message = 'Something went wrong';
        }

        return redirect()->route("backend.tasks.view")->with($key, $message);

    }
}
