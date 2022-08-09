<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContributorController;
use App\Http\Controllers\LotController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\PaypalPaymentController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\RegisterController;
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

Route::post('/register-organization', [RegisterController::class, 'registerOrganization']);
Route::post('/register-contributor', [RegisterController::class, 'registerContributor']);
Route::post('/login', [AuthController::class, 'login']);

Route::apiResource('/organizations', OrganizationController::class)->only('index', 'show');

Route::apiResource('/lots', LotController::class)->only('index', 'show');

Route::group(['middleware' => ['auth:sanctum']], function () {

   Route::post('/logout', [AuthController::class, 'logout']);
   Route::get('/user', [AuthController::class, 'getUserByToken']);

   Route::get('/history', [ContributorController::class, 'getDonationHistory']);

   Route::apiResource('/organizations', OrganizationController::class)->only('update');

   Route::apiResource('/lots', LotController::class)->only('store', 'update', 'destroy');

   Route::prefix('stripe')->controller(StripePaymentController::class)->group(function () {
       Route::post('/donate/{lot}', 'donate');
   });

    Route::prefix('paypal')->controller(PaypalPaymentController::class)->group(function () {
        Route::post('/donate', 'donate');
        Route::post('/{id}/capture/{lotId}', 'capture');
        Route::post('/register', 'registerMerchant');
//        Route::post('/set/{id}', 'setMerchantId');
    });

});
