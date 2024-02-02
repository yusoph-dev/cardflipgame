<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Record;
use Illuminate\Validation\Rule;



class PlayerController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //
    }

    /**  
     * success response method.  
     *  
     * @return \Illuminate\Http\Response  
     */  
    public function getRankings(Request $request)  
    {  
        // Your logic to retrieve rankings from the database
        $rankings = Record::orderBy('points', 'desc')->get();

        // Assuming you're returning a JSON response
        return response()->json(['rankings' => $rankings]);
    }
    
    /**  
     * success response method.  
     *  
     * @return \Illuminate\Http\Response  
     */  
    public function postPlayer(Request $request)  
    {  
        // Validate the incoming request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'difficulty' => ['required', 'numeric', Rule::in([1, 2, 3, 5])], // Adjust the allowed difficulty levels
            'seconds' => 'required|numeric|min:0',
        ]);

        // set base maximum points
        $maxPoints = 33333;

        // get raw maximum points
        $points = max(0, $maxPoints - $validatedData['seconds'] * ($maxPoints / 3600));

        // Ensure points are not negative
        $getCeiling = max($points, 0);

        // Multiply points based on the difficulty selected
        $finalPoint = round($getCeiling * $validatedData['difficulty']);

        $newRecord = new Record;
        $newRecord->name = $validatedData['name'];
        $newRecord->difficulty = $validatedData['difficulty'];
        $newRecord->points = $finalPoint;
        $newRecord->seconds = $validatedData['seconds'];
        $newRecord->save();

        return array('success' => true, 'last_insert_id' => $newRecord->id, 'points' => $finalPoint);
    }  
}
