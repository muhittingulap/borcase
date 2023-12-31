<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\VehicleController;
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

Route::get('/', function (Request $request) {
    return response()->json([
        "status" => true,
        "message" => "BorHolding Laravel API (v1.0) !"
    ]);
});

Route::post('/login', [AuthController::class, 'login']);

/* Protected Routes */
Route::group(['middleware' => ['auth:sanctum']], function () {

    // Users Routes
    Route::resource('employees', EmployeeController::class);

    // Company Routes
    Route::resource('vehicles', VehicleController::class);

    // Auth Routes
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
