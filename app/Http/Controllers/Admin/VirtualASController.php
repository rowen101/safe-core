<?php

namespace App\Http\Controllers\Admin;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class VirtualASController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = auth()->user()->id;

        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $dailyTasks = Task::orderBy('taskdate', 'asc')
            ->with('taskLists')
            ->where('user_id', $userId)
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->get();

        $tasksList = Task::withCount([
            'taskLists',
            'taskLists as completed_task_count' => function ($query) {
                $query->where('iscompleted', 1);
            }
        ])
            ->where('user_id', $userId)
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->orderBy('id', 'asc')
            ->get();

        // Calculate the percentage of completed tasks
        $tasksList->transform(function ($task) {
            $task->percentage_completed = ($task->task_lists_count > 0)
                ? ($task->completed_task_count / $task->task_lists_count) * 100
                : 0;
            return $task;
        });

        return response()->json(['dailyTasks' => $dailyTasks, 'TaskList' => $tasksList]);
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

    public function FilterVSC(Request $request)
    {
        $userId = auth()->user()->id;

        // Retrieve start and end dates from the request
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date)->endOfDay();

        $dailyTasks = Task::orderBy('taskdate', 'asc')
            ->with('taskLists')
            ->where('user_id', $userId)
            ->whereBetween('taskdate', [$startDate, $endDate])
            ->get();

        $tasksList = Task::withCount([
            'taskLists',
            'taskLists as completed_task_count' => function ($query) {
                $query->where('iscompleted', 1);
            }
        ])
            ->where('user_id', $userId)
            ->whereBetween('taskdate', [$startDate, $endDate])
            ->orderBy('id', 'asc')
            ->get();

        // Calculate the percentage of completed tasks
        $tasksList->transform(function ($task) {
            $task->percentage_completed = ($task->task_lists_count > 0)
                ? ($task->completed_task_count / $task->task_lists_count) * 100
                : 0;
            return $task;
        });

        return response()->json(['dailyTasks' => $dailyTasks, 'TaskList' => $tasksList]);
    }
}
