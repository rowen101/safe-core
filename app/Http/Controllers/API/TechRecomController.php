<?php

namespace App\Http\Controllers\API;

use App\Models\Tech;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TechRecomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tech = Tech::all()->toArray();
        return response()->json($tech);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'company'  => 'required',
        // ]);

        // Find the latest "techno" entry in the database
        $latestTechno = Tech::orderBy('id', 'desc')->first();

        // Determine the next "techno" number
        if ($latestTechno) {
            $lastNumber = intval(substr($latestTechno->techno, 3)); // Assuming the current format is TEC####
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1; // If no previous record exists, start from 1
        }

        // Generate the new "techno" value
        $techno = 'TECH' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT); // Padded to 4 digits

        Tech::updateOrCreate([
            'id' => $request->id,
            'updated_by' => $request->updated_by
        ],
        [
            'techno' => $techno, // Updated 'techno' with the generated value
            'company' => "Safexpress Logistics Inc",
            'branch' => $request->branch,
            'department' => $request->department,
            'warehouse' => $request->warehouse,
            'user' => $request->user,
            'report' => $request->report,
            'udetails' => $request->udetails,
            'ass_conducted' => $request->ass_conducted,
            'recommendation' => $request->recommendation,
            'created_by' => $request->created_by,
        ]);

        return response()->json(['success' => 'Record saved successfully!']);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tech = Tech::find($id);
        return response()->json($tech);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tech = Tech::find($id);
        return response()->json($tech);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Tech::find($id)->delete();

        return response()->json(['success'=>'Tech Recommendation deleted successfully.']);
    }
}
