<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Record;
use Illuminate\Validation\Rule;
use App\Models\Session; 




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
     * load rankings
     *  
     */  
    public function getRankings(Request $request)  
    {  
        // Your logic to retrieve rankings from the database
        $rankings = Record::orderBy('points', 'desc')->get();

        // Assuming you're returning a JSON response
        return response()->json(['rankings' => $rankings]);
    }


    /**  
     * get current saved session if there is
     *  
     */ 
    public function getSession(Request $request){

        $session_id = $request->cookie('laravel_session');

        $session = Session::where('laravel_session', $session_id)->first();

        if ($session) {
            // Convert JSON columns to objects
            $session->cards = json_decode($session->cards);
            $session->random_cards = json_decode($session->random_cards);
            $session->first_card = json_decode($session->first_card);

            // Return the session values
            return response()->json([
                'message' => 'Session retrieved successfully',
                'session' => $session,
            ]);
        } else {
            // The session with the specified ID was not found
            return response()->json(['message' => 'Session not found'], 404);
        }
    }

    /**  
     * post player data for rankings
     *  
     */ 
    public function postPlayer(Request $request)  
    {  
        // Validate the incoming request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'difficulty' => ['required', 'numeric', Rule::in([1, 2, 3, 5])], // Adjust the allowed difficulty levels
            'seconds' => 'required|numeric|min:0',
            'flips' => 'numeric|min:0'
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
        $newRecord->flips = $validatedData['flips'];
        $newRecord->save();


        $session_status = false;
        $session_id = $request->cookie('laravel_session');

        // Find and delete the session based on the laravel_session value
        $deletedRows = Session::where('laravel_session', $session_id)->delete();

        if ($deletedRows > 0) {
            // Rows were deleted successfully
            $session_status = true;
        }

        return array('success' => true, 'last_insert_id' => $newRecord->id, 'points' => $finalPoint, 'session_delete', $session_status);
    }

    /**  
     * post session data incase the browser closed / refreshed etc.
     *  
     */ 
    public function postSession(Request $request)
    {
        $validatedData = $request->validate([
            'initial' => 'nullable|boolean',
            'count' => 'nullable|integer',
            'active' => 'nullable|boolean',
            'difficulty' => 'nullable|integer',
            'cards' => 'nullable|json',
            'random_cards' => 'nullable|json',
            'matched_cards' => 'nullable|integer',
            'first_card' => 'nullable|json',
            'verifying' => 'nullable|boolean',
            'player_name' => 'nullable|string|max:255',
            'timer_seconds' => 'nullable|integer',
            'total_score' => 'nullable|integer',
            'timer_interval' => 'nullable|integer',
            'showModal' => 'nullable|boolean',
        ]);

        $session_id = $request->cookie('laravel_session');

        Session::updateOrInsert(
            ['laravel_session' => $session_id],
            $validatedData
        );


        return response()->json(['message' => 'Session created or updated successfully'], 201);
    }
}
