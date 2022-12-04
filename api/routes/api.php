<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContributorController;
use App\Http\Controllers\LotController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\PaypalPaymentController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Middleware\CheckContributor;
use App\Http\Middleware\CheckOrganization;
use App\Http\Middleware\CheckSubscription;
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

   Route::apiResource('/organizations', OrganizationController::class)->only('update');

   Route::apiResource('/lots', LotController::class)->only('store', 'update', 'destroy');

   Route::middleware(CheckContributor::class)->prefix('contributor')->controller(ContributorController::class)->group(function () {
       Route::get('/history', 'getDonationHistory');
       Route::get('/settings', 'getSettings');
       Route::patch('/settings', 'updateSettings');

       Route::get('/last-month', 'lastMonthDonates');
       Route::get('/average', 'averagePerMonth');
       Route::get('/most-donated', 'donatedTheMost');
   });

   Route::middleware(CheckOrganization::class)->prefix('organization')->controller(LotController::class)->group(function () {
       Route::get('/lots', 'getLotsByOrganization');

       Route::get('/statistics', [OrganizationController::class, 'getOrganizationStatistics']);
       Route::get('/statistics/{lot}', 'getLotStatistics');
       Route::get('/history/{lot}', 'getLotDonationHistory');

       Route::get('/last-week-sum', [OrganizationController::class, 'lastWeekContributorsDonates']);
       Route::get('/last-week-transactions', [OrganizationController::class, 'lastWeekContributorsTransactions']);
       Route::get('/top-contributors', [OrganizationController::class, 'topContributorsForTheYear']);
   });

   Route::prefix('subscriptions')->controller(SubscriptionController::class)->group(function () {
       Route::get('/tariffs', 'getSubscriptionTariffs');
       Route::post('/subscribe/{id}', 'payForSubscription')->middleware([CheckSubscription::class]);
       Route::patch('/change-tariff/{id}', 'changeTariff');
   });

   Route::prefix('stripe')->controller(StripePaymentController::class)->group(function () {
       Route::post('/donate/{lot}', 'donate');
   });

    Route::prefix('paypal')->controller(PaypalPaymentController::class)->group(function () {
        Route::post('/donate', 'donate');
        Route::post('/{id}/capture/{lotId}', 'capture');
        Route::post('/register', 'registerMerchant');
        Route::post('/set/{id}', 'setMerchantId');
    });

});
