<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enums\TaskType;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        $data = Task::query()
        ->when(request('query'), function ($query, $searchQuery) {
            $query->where('site', 'like', "%{$searchQuery}%");
            $query->where('type', TaskType::from(request('type')));
        })
        ->latest()
        ->paginate(setting('pagination_limit'))
        ->through(fn ($dailytask)=>[
            'id' => $dailytask->id,
            'site'=> $dailytask->site,
            'user_id' => $dailytask->user_id,
            'project' => $dailytask->project,
            'plandate' => $dailytask->plandate,
            'planenddate'=> $dailytask->planenddate,
            'startdate' => $dailytask->startdate,
            'enddate' => $dailytask->enddate,
            'tasktype' => [
                'name' => $dailytask->tasktype->name,
                'listtask' => $dailytask->tasktype->listtask(),
            ],
            'status' => $dailytask->branch,
            'attachment' => $dailytask->department,
            'PWS' => $dailytask->created_by,
            'remarks' => $dailytask->created_by,
            'immediate_hid' => $dailytask->created_by,
            'created_at' => $dailytask->created_at->format('Y-m-d h:i A'),


        ]);

         return $data;
    }

    public function store(){
        request()->validate([
            'site' => 'required',
            'tasktype' => 'required',
            'taskname' => 'required',
            'plandate' => 'required',
            'planenddate' => 'required',
        ]);


             Task::create([
            'site' => request('site'),
            'user_id' => request('user_id'),
            'project' => request('project'),
            'plandate' => request('plandate'),
            'planenddate' => request('planenddate'),
            'startdate' => request('startdate'),
            'enddate' => request('enddate'),
            'tasktype' => request('tasktype'),
            'tastname' => request('taskname'),
            'status' => request('status'),
            'attachment' => request('attachment'),
            'PWS' => request('PWS'),
            'remarks' => request('remarks'),
            'immediate_hid' => request('immediate_hid'),
            'status_task' => request('status_task'),

        ]);
       return response()->json(['message' => 'success']);
    }
}
