<?php

namespace App\Http\Controllers\Admin;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class VirtualSCController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $userId = auth()->user()->id;

        $dailyTasks = Task::with('taskLists')
        ->where('user_id', $userId)

        ->get();


    $TasksList = Task::withCount(['taskLists', 'taskLists as completed_task_count' => function ($query) {
        $query->where('iscompleted', 1);
    }])
    ->get();

    // $TasksList = Task::with([
    //     'taskLists',
    //     'taskLists as completed_task_count' => function ($query) {
    //         $query->where('iscompleted', 1);
    //     },
    // ])
    // ->get()
    // ->map(function ($task) {
    //     $totalTasks = $task->task_lists_count; // Total number of tasks
    //     $completedTasks = $task->completed_task_count; // Number of completed tasks

    //     // Calculate the percentage
    //     $percentage = ($totalTasks > 0) ? ($completedTasks / $totalTasks) * 100 : 0;

    //     // Add the percentage attribute to the task
    //     $task->percentage_completed = $percentage;

    //     return $task;
    // });



        return response()->json(['dailyTasks' =>$dailyTasks,'TaskList' =>$TasksList]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
