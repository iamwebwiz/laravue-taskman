<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Fetch all tasks
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::all();
        
        return response()->json([
            'tasks' => $tasks
        ], 200);
    }

    /**
     * Create a new Task resource
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'body' => 'required'
        ]);

        $task = Task::create([
            'body' => request('body')
        ]);

        return response()->json([
            'task' => $task,
            'message' => 'Successfully created task.'
        ], 201);
    }

    /**
     * Update a Task resource
     * 
     * @param \Illuminate\Http\Request $request
     * @param \App\Task $task
     * @return \Illuminate\Http\Request
     */
    public function update(Request $request, Task $task)
    {
        $this->validate($request, [
            'body' => 'required|text'
        ]);

        $task->body = request('body');
        $task->save();

        return response()->json([
            'message' => 'Task has been updated.'
        ], 200);
    }

    /**
     * Delete a Task resource
     * 
     * @param \App\Task $task
     * @return \Illuminate\Http\Response
     */
    public function delete(Task $task)
    {
        $task->delete();

        return response()->json([
            'message' => 'Task has been deleted.'
        ], 200);
    }
}
