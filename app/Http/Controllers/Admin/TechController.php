<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TechRecomStatus;
use App\Http\Controllers\Controller;
use App\Models\TechRecomm;
use Illuminate\Http\Request;

class TechController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = TechRecomm::query()
        ->when(request('query'), function ($query, $searchQuery) {
            $query->where('user', 'like', "%{$searchQuery}%");
            $query->where('status', TechRecomStatus::from(request('status')));
        })
        ->latest()
        ->paginate(setting('pagination_limit'))
        ->through(fn ($techRecomStatus)=>[
            'id' => $techRecomStatus->id,
            'recommnum'=> $techRecomStatus->recommnum,
            'user' => $techRecomStatus->user,
            'model' => $techRecomStatus->model,
            'assettag' => $techRecomStatus->assettag,
            'serialnum'=> $techRecomStatus->serialnum,
            'problem' => $techRecomStatus->problem,
            'assconducted' => $techRecomStatus->assconducted,
            'recommendation' => $techRecomStatus->recommendation,
            'branch' => $techRecomStatus->branch,
            'department' => $techRecomStatus->department,
            'created_by' => $techRecomStatus->created_by,
             'created_at' => $techRecomStatus->created_at->format('Y-m-d h:i A'),
            'status' => [
                'name' => $techRecomStatus->status->name,
                'color' => $techRecomStatus->status->color(),
            ],

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
    public function store()
    {
        request()->validate([
            'branch' => 'required',
            'department' => 'required',
            'user' => 'required',
            'problem' => 'required',
            'assconducted' => 'required',
        ]);

        // Find the latest TECH recommendation
        $latestRecommendation = TechRecomm::latest('id')->first();

        // Extract the last recommendation number if available
        $lastRecommNum = optional($latestRecommendation)->recommnum;

        // Increment the recommendation number
        $recommnum = 'TECH' . str_pad(
            (intval(substr($lastRecommNum, 4)) + 1),
            strlen($lastRecommNum) - 4,
            '0',
            STR_PAD_LEFT
        );

        return TechRecomm::create([
            'recommnum' => $recommnum,
            'company' => 'Safexpress Logistics Corp.',
            'branch' => request('branch'),
            'department' => request('department'),
            'warehouse' => request('warehouse'),
            'user' => request('user'),
            'problem' => request('problem'),
            'model' => request('model'),
            'assettag' => request('assettag'),
            'serialnum' => request('serialnum'),
            'assconducted' => request('assconducted'),
            'recommendation' => request('recommendation'),
            'status' => 1,
            'created_by' => request('created_by'),
            'updated_by' => 0,

        ]);
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
    public function update(TechRecomm $tech)
    {
        request()->validate([
            'department' => 'required',
            'user' => 'required',
            'problem' => 'required',
            'assconducted' => 'required',

        ]);

        $tech->update([
            'company' => 'Safexpress Logistics Corp.',
            'branch' => request('branch'),
            'department' => request('department'),
            'warehouse' => request('warehouse'),
            'user' => request('user'),
            'problem' => request('problem'),
            'model' => request('model'),
            'assettag' => request('assettag'),
            'serialnum' => request('serialnum'),
            'assconducted' => request('assconducted'),
            'recommendation' => request('recommendation'),
            'status' => 1,
            'created_by' => request('created_by'),
            'updated_by' => 0,

        ]);

        return $tech;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        $data = TechRecomm::find($id);
        $data->delete();
        return response()->json(['success' => 200]);
    }

    public function bulkDelete()
    {
        TechRecomm::whereIn('id', request('ids'))->delete();

        return response()->json(['message' => 'Data deleted successfully!']);
    }
}
