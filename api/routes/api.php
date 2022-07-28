<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LotController;
use App\Http\Middleware\CheckOrganization;
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

Route::post('/register-organization', [AuthController::class, 'registerOrganization']);
Route::post('/register-contributor', [AuthController::class, 'registerContributor']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {

   Route::post('logout', [AuthController::class, 'logout']);

   Route::group(['middleware' => CheckOrganization::class], function () {
       Route::apiResource('/lots', LotController::class);
   });

});