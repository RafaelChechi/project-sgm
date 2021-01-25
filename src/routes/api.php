<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("/project", [ProjectController::class, "index"]);
Route::post("/project", [ProjectController::class, "create"]);
Route::put("/project/{id}", [ProjectController::class, "update"]);
Route::delete("/project/{id}", [ProjectController::class, "destroy"]);
