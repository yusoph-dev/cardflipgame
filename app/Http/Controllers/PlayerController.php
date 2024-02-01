<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Record;


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

        // set base maximum points
        $maxPoints = 33333;

        // get raw maximum points
        $points = max(0, $maxPoints - $request->seconds * ($maxPoints / 3600));

        // Ensure points are not negative
        $getCeiling = max($points, 0);

        // Multiply points based on the difficulty selected
        $finalPoint = round($getCeiling * $request->difficulty);

        $newRecord = new Record;
        $newRecord->name = $request->name;
        $newRecord->difficulty = $request->difficulty;
        $newRecord->points = $finalPoint;
        $newRecord->seconds = $request->seconds;
        $newRecord->save();

        return array('success' => true, 'last_insert_id' => $newRecord->id, 'points' => $finalPoint);
    }  
}