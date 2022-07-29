<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LotController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RegisterController;
use App\Jobs\SendReport;
use App\Jobs\SendReportsToContributors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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

Route::post('/register-organization', [RegisterController::class, 'registerOrganization']);
Route::post('/register-contributor', [RegisterController::class, 'registerContributor']);
Route::post('/login', [AuthController::class, 'login']);

Route::apiResource('/lots', LotController::class)->only('index', 'show');

Route::group(['middleware' => ['auth:sanctum']], function () {

//    Route::get('/greeting', function () {
//        dispatch(new SendReportsToContributors());
////        dispatch(new SendReport(\App\Models\Contributor::find(3)));
//    });

   Route::post('/logout', [AuthController::class, 'logout']);

   Route::post('/donate/{lot}', [PaymentController::class, 'donate']);

   Route::apiResource('/lots', LotController::class)->only('store', 'update', 'destroy');

});
