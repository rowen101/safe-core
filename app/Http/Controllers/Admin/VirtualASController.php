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

        $dailyTasks = Task::orderBy('tbl_dailytask.taskdate', 'asc')
        ->join('tbl_sites', 'tbl_sites.id', '=', 'tbl_dailytask.site')
        ->with('taskLists')
        ->where('user_id', $userId)
        ->whereBetween('tbl_dailytask.taskdate', [$startOfWeek, $endOfWeek])
        ->whereBetween('tbl_dailytask.created_at', [$startOfWeek, $endOfWeek]) // Add this line
        ->select('tbl_dailytask.*', 'tbl_sites.site_name')
        ->orderBy('taskdate', 'asc')
        ->get();


        $tasksList = Task::withCount([
            'taskLists',
            'taskLists as completed_task_count' => function ($query) {
                $query->where('iscompleted', 1);
            }
        ])
            ->where('user_id', $userId)
            ->whereBetween('taskdate', [$startOfWeek, $endOfWeek])
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek]) // Add this line
            ->orderBy('taskdate', 'asc')
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
    $endDate = Carbon::parse($request->end_date); // Ensure it's the end of the day

    $dailyTasks = Task::orderBy('tbl_dailytask.taskdate', 'asc')
        ->join('tbl_sites', 'tbl_sites.id', '=', 'tbl_dailytask.site')
        ->with('taskLists')
        ->where('user_id', $userId)
        ->whereBetween('tbl_dailytask.taskdate', [$startDate, $endDate])
        ->select('tbl_dailytask.*', 'tbl_sites.site_name')
        ->get();

    $tasksList = Task::withCount([
        'taskLists',
        'taskLists as completed_task_count' => function ($query) {
            $query->where('iscompleted', 1);
        }
    ])
        ->where('user_id', $userId)
        ->whereBetween('taskdate', [$startDate, $endDate])
        ->orderBy('dailytask_id', 'asc')
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
