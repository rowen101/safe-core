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

        // Get the start and end of the current week
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        // Get the start and end of the next week
        $startOfNextWeek = Carbon::now()->startOfWeek()->addWeek();
        $endOfNextWeek = Carbon::now()->endOfWeek()->addWeek();

        // Get tasks for the current week
        $dailyTasks = Task::orderBy('tbl_dailytask.taskdate', 'asc')
            ->join('tbl_sites', 'tbl_sites.id', '=', 'tbl_dailytask.site')
            ->with('taskLists')
            ->where('user_id', $userId)
            ->whereBetween('tbl_dailytask.taskdate', [$startOfWeek, $endOfWeek])
            ->select('tbl_dailytask.*', 'tbl_sites.site_name')
            ->orderBy('taskdate', 'asc')
            ->get();

        // Get tasks for the next week
        $nextWeekTasks = Task::orderBy('tbl_dailytask.taskdate', 'asc')
            ->join('tbl_sites', 'tbl_sites.id', '=', 'tbl_dailytask.site')
            ->with('taskLists')
            ->where('user_id', $userId)
            ->whereBetween('tbl_dailytask.taskdate', [$startOfNextWeek, $endOfNextWeek])
            ->select('tbl_dailytask.*', 'tbl_sites.site_name')
            ->orderBy('taskdate', 'asc')
            ->get();

        // Combine tasks for both weeks
        $allTasks = $dailyTasks->merge($nextWeekTasks);

        $tasksList = Task::withCount([
            'taskLists',
            'taskLists as completed_task_count' => function ($query) {
                $query->where('iscompleted', 1);
            }
        ])
            ->where('user_id', $userId)
            ->whereIn('taskdate', $allTasks->pluck('taskdate')->unique())
            ->orderBy('taskdate', 'asc')
            ->get();

        // Calculate the percentage of completed tasks
        $tasksList->transform(function ($task) {
            $task->percentage_completed = ($task->task_lists_count > 0)
                ? ($task->completed_task_count / $task->task_lists_count) * 100
                : 0;
            return $task;
        });

        return response()->json(['dailyTasks' => $allTasks, 'TaskList' => $tasksList]);
    }

    public function vscfilter(Request $request)
    {
        $userId = auth()->user()->id;

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

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
            ->whereBetween('tbl_dailytask.taskdate', [$startDate, $endDate])
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
}
