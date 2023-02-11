<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::any('/bot',[\App\Http\Controllers\BotController::class,'index']);

Route::any('/verify',[\App\Http\Controllers\BotController::class,'verify_bot']);



// Route::any('/bot', function(Request $input)
// {
//     if (isset($input['hub_verify_token'])) { ## allows facebook verify that this is the right webhook
//         if ($input['hub_verify_token'] ==="EmmaToken") {
//             return $input['hub_challenge'];
//             dd();
//         } else {
//             echo 'Invalid Verify Token';
//             dd();
//         }
//     }
// });
