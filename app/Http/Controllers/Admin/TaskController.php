<?php

namespace App\Http\Controllers\Admin;

use App\Models\Task;
use App\Enums\TaskType;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    public function index()
    {
        // $startOfWeek = Carbon::now()->startOfWeek();
        // $endOfWeek = Carbon::now()->endOfWeek();
        $data = Task::query()
            ->when(request('query'), function ($query, $searchQuery) {
                $query->where('site', 'like', "%{$searchQuery}%");
                $query->where('type', TaskType::from(request('type')));
            })
            // ->whereBetween('plandate', [$startOfWeek, $endOfWeek])
            ->where('status_task', null)
            ->where ('user_id', auth()->user()->id)
            ->latest()
            ->get() // Replace paginate with get to retrieve all records
            ->map(fn ($dailytask) => [
                'id' => $dailytask->id,
                'site' => $dailytask->site,
                'user_id' => $dailytask->user_id,
                'taskdate' => $dailytask->taskdate,
                'project' => $dailytask->project,
                'plandate' => $dailytask->plandate,
                'planenddate' => $dailytask->planenddate,
                'startdate' => $dailytask->startdate,
                'enddate' => $dailytask->enddate,
                'tasktype' => [
                    'listtask' => $dailytask->tasktype->listtask(),
                ],
                'status' => $dailytask->status,
                'attachment' => $dailytask->attachment,
                'PWS' => $dailytask->PWS,
                'remarks' => $dailytask->remarks,
                'immediate_hid' => $dailytask->immediate_hid,
                'created_at' => $dailytask->created_at->format('m/d/Y h:i A'),
            ]);

        return $data;
    }


    public function store()
    {


        request()->validate([
            'site' => 'required',
            'tasktype' => 'required',
            'taskname' => 'required',
            'plandate' => 'required',
            'planenddate' => 'required',
        ]);

        // Parse the date range
        $startDate = Carbon::parse(request('plandate'));
        $endDate = Carbon::parse(request('planenddate'));

        // Loop through the date range and create tasks
        while ($startDate <= $endDate) {
            Task::create([
                'site' => request('site'),
                'user_id' => request('user_id'),
                'taskdate' => $startDate,
                'project' => request('project'),
                'plandate' => request('plandate'),
                'planenddate' => request('planenddate'),
                'startdate' => request('startdate'),
                'enddate' => request('enddate'),
                'tasktype' => request('tasktype'),
                'taskname' => request('taskname'),
                'status' => request('status'),
                'attachment' => request('attachment'),
                'PWS' => request('PWS'),
                'remarks' => request('remarks'),
                'immediate_hid' => 1,
                'status_task' => request('status_task'),
            ]);

            // Move to the next day
            $startDate->addDay();
        }


        return response()->json(['message' => 'success']);
    }

    public function onhandler(Request $request, $id)
    {

        // $task = Task::find($id);
        // $task->startdate = $request->input('startdate');
        // $task->status = "On Going";

        // $task->save();
        // return response()->json(['message' => 'Task start successfully!']);
        $task = Task::find($id);

        // Check if the start date is empty
        if (empty($request->input('startdate'))) {
            $task->startdate = now(); // Set the start date to the current date and time
            $task->status = "On Going";
        } else {
            // Start date is not empty, update end date and status
            $task->enddate = now(); // You may want to replace 'now()' with the appropriate logic to set the end date
            $task->status = $request->status; // Set the status accordingly
            $task->status_task = 1;
        }

        $task->save();

        return response()->json(['message' => 'Task updated successfully!']);
    }
}
