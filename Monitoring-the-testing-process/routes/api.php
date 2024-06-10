<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\StudentController;
use App\Http\Controllers\API\TestController;
use App\Http\Controllers\API\GradeController;

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


Route::get('/students', [StudentController::class, 'index']);
Route::post('/students', [StudentController::class, 'store']);
Route::get('/students/{id}', [StudentController::class, 'show']);
Route::put('/students/{id}', [StudentController::class, 'update']);
Route::delete('/students/{id}', [StudentController::class, 'destroy']);

Route::get('/tests', [TestController::class, 'index']);
Route::post('/tests', [TestController::class, 'store']);
Route::get('/tests/{id}', [TestController::class, 'show']);
Route::put('/tests/{id}', [TestController::class, 'update']);
Route::delete('/tests/{id}', [TestController::class, 'destroy']);

Route::get('/grades', [GradeController::class, 'index']);
Route::post('/grades', [GradeController::class, 'store']);
Route::get('/grades/{id}', [GradeController::class, 'show']);
Route::put('/grades/{id}', [GradeController::class, 'update']);
Route::delete('/grades/{id}', [GradeController::class, 'destroy']);
