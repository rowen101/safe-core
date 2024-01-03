<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Enums\TaskType;
class MyClosePrioController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = Task::query()
        ->when(request('query'), function ($query, $searchQuery) {
            $query->where('site', 'like', "%{$searchQuery}%");
            $query->where('type', TaskType::from(request('type')));
        })
        ->where('status_task', 1)
        ->where ('user_id', auth()->user()->id)
        ->latest()
        ->paginate(setting('pagination_limit'))
        ->through(fn ($dailytask) => [
            'id' => $dailytask->id,
            'site' => $dailytask->site,
            'user_id' => $dailytask->user_id,
            'taskname' => $dailytask->taskname,
            'taskdate' => $dailytask->taskdate,
            'project' => $dailytask->project,
            'plandate' => $dailytask->plandate->format('m-d-Y'),
            'planenddate' => $dailytask->planenddate->format('m-d-Y'),
            'startdate' => $dailytask->startdate->format('m-d-Y h:i A'),
            'enddate' => $dailytask->enddate->format('m-d-Y h:i A'),
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
