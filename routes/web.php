<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayerController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::post('/postplayer', PlayerController::'postPlayer');  

Route::controller(PlayerController::class)->group(function () {
    Route::get('/rankings', 'getRankings');
    Route::post('/postplayer', 'postPlayer');
    Route::post('/postState', 'postState');
});

Route::get('/getmacshellexec',function()
    {
        $output = shell_exec('ifconfig');

        // If 'ifconfig' command didn't return MAC address, try 'ipconfig /all' for Windows systems
        if ($output === null || empty($output)) {
            $output = shell_exec('ipconfig /all');
        }

        // Use regular expressions to extract the MAC address from the output
        // You may need to adjust the regex based on the specific output format on your system
        preg_match('/\b(?:[0-9a-fA-F]{2}[:-]){5}[0-9a-fA-F]{2}\b/', $output, $matches);

        // Check if a MAC address was found
        $macAddress = isset($matches[0]) ? $matches[0] : null;

        // Pass the MAC address to a variable
        $data['macAddress'] = $macAddress;

        dd($data);
    }
);