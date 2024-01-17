<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AirplaneTicketController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\ResortApiController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\TestimonialApiController;
use App\Http\Controllers\YourMomentApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::resource('users', UserController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/resorts', [ResortApiController::class, 'index'])->name('api.resorts.index');
Route::get('/your-moments', [YourMomentApiController::class, 'index']);
Route::get('/testemonials', [TestimonialApiController::class, 'index']);


Route::get('/subscribers', [SubscriberController::class, 'index']);
Route::post('/subscribers', [SubscriberController::class, 'store']);
Route::delete('/subscribers/{id}', [SubscriberController::class, 'softDeleteSubscriber']);
                                            
Route::delete('/editor/contactUs/{contactUs}', [ContactUsController::class, 'destroy'])->name('contactUs.delete');
Route::apiResource('contact-us', ContactUsController::class)->except(['destroy']);
Route::delete('/editor/airplane-tickets/{airplane_ticket}', 'AirplaneTicketController@destroy')->name('airplaneTicket.delete');
Route::apiResource('airplane-tickets', AirplaneTicketController::class)->except(['destroy']);

