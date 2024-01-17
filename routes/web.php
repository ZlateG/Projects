<?php

use App\Http\Controllers\Admin\AdminRegisterController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AirplaneTicketController;
use App\Http\Controllers\ApartmantImageController;
use App\Http\Controllers\ApartmantPriceController;
use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\Editor\DashboardController;
use App\Http\Controllers\ResortController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\YourMomentController;
use Illuminate\Support\Facades\Route;












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
    return view('auth.login');
});


// Route::delete('/editor/contactUs/{id}', [ContactUsController::class, 'destroy'])->name('contactUs.delete');

Route::get('/unsubscribe/{id}', [SubscriberController::class, 'unsubscribe'])->name('unsubscribe');
Route::get('/getCities/{countryId}', [ResortController::class, 'getCities'])->name('getCities');

Route::middleware(['auth'])->group(function () {
    Route::get('/editor/dashboard', [DashboardController::class, 'index'])->name('editor.dashboard');
    Route::get('/editor/subscribers', [SubscriberController::class, 'index'])->name('editor.subscribers');
    Route::delete('/editor/airplane-tickets/{airplane_ticket}', [AirplaneTicketController::class, 'destroy'])->name('airplaneTicket.delete');
    
    Route::post('/country', [CountryController::class, 'store'])->name('country.store');
    Route::get('/country/edit/{id}', [CountryController::class, 'edit'])->name('country.edit');
    Route::put('/countries/{id}', [CountryController::class, 'update'])->name('countries.update');
    Route::delete('/countries/{id}/soft-delete', [CountryController::class, 'softDelete'])->name('countries.softDelete');
    Route::put('countries/restore/{id}', [CountryController::class, 'restoreCountry'])->name('countries.restore');
    
    // web.php or routes/web.php
    
    
    // Route::delete('/perm-delete/{id}', [AirplaneTicketController::class, 'destroy'])->name('airplaneTicket.delete');
    // Route::delete('/editor/airplane-tickets/{airplane_ticket}', 'AirplaneTicketController@destroy')->name('airplaneTicket.delete');
    

    Route::post('/city', [CityController::class, 'store'])->name('city.store');
    Route::get('/city/edit/{id}', [CityController::class, 'edit'])->name('city.edit');
    Route::put('/cities/{id}', [CityController::class, 'update'])->name('cities.update');
    Route::delete('/cities/{id}/soft-delete', [CityController::class, 'softDelete'])->name('cities.softDelete');
    Route::put('/cities/restore/{id}', [CityController::class, 'restoreCity'])->name('cities.restore');

    Route::prefix('resorts')->group(function () {
        Route::patch('/{id}/update-visibility', [ResortController::class, 'updateVisibility'])->name('resorts.updateVisibility');
        Route::patch('/{id}/update-last-minute', [ResortController::class, 'updateLastMinute'])->name('resorts.updateLastMinute');
        Route::put('/restore/{id}', [ResortController::class, 'restoreResort'])->name('resort.restore');
        Route::delete('/{id}/soft-delete', [ResortController::class, 'softDelete'])->name('resort.softDelete');
        Route::get('/edit/{id}', [ResortController::class, 'edit'])->name('resort.edit');
        Route::put('/{id}', [ResortController::class, 'update'])->name('resort.update');
        Route::post('/', [ResortController::class, 'store'])->name('resorts.store');
        Route::put('/move-down/{id}', [ResortController::class, 'moveDown'])->name('resorts.moveDown');
        Route::put('/move-up/{id}', [ResortController::class, 'moveUp'])->name('resorts.moveUp');
    });    
    Route::delete('/resort/perm-delete/{id}', [ResortController::class, 'permDelete'])->name('resort.permDelete');

    Route::delete('/apartment-images/{id}', [ApartmantImageController::class, 'destroy'])->name('apartment-images.destroy');
    Route::post('/apartments', [ApartmentController::class, 'store'])->name('apartments.store');
    Route::delete('/apartments/{id}/soft-delete', [ApartmentController::class, 'softDelete'])->name('apartments.softDelete');
    Route::put('/apartments/restore/{id}', [ApartmentController::class, 'restoreApartment'])->name('apartments.restore');
    Route::delete('/apartments/perm-delete/{id}', [ApartmentController::class, 'permDelete'])->name('apartments.permDelete');
    Route::get('/apartments/edit/{id}', [ApartmentController::class, 'edit'])->name('apartments.edit');
    Route::put('/apartments/{id}', [ApartmentController::class, 'update'])->name('apartments.update');

    Route::delete('/prices/delete/{priceId}', [ApartmantPriceController::class, 'destroy'])->name('prices.destroy');

    Route::put('/prices/{priceId}', [ApartmantPriceController::class, 'update'])->name('prices.update');
    Route::post('/prices', [ApartmantPriceController::class, 'store'])->name('prices.store');

    Route::post('/store', [ApartmantImageController::class, 'store'])->name('apartmantImage.store');

    Route::delete('/apartments', [ApartmentController::class, 'store'])->name('apartments.store');

    Route::get('/destinations', [DestinationController::class, 'index'])->name('destinations.index');

    Route::prefix('testimonials')->group(function () {
        Route::get('/edit/{id}', [TestimonialController::class, 'edit'])->name('testimonials.edit');
        Route::put('/update/{id}', [TestimonialController::class, 'update'])->name('testimonials.update');
        Route::get('/index', [TestimonialController::class, 'index'])->name('testimonials.index');
        Route::post('/store', [TestimonialController::class, 'store'])->name('testimonials.store');
        Route::delete('/{id}', [TestimonialController::class, 'softDelete'])->name('testimonials.remove');
        Route::delete('/perm-delete/{id}', [TestimonialController::class, 'permDelete'])->name('testimonials.delete');
        Route::put('/restore/{id}', [TestimonialController::class, 'restoreTestimonial'])->name('testimonials.restore');
        Route::put('/move-up/{id}', [TestimonialController::class, 'moveUp'])->name('testimonials.moveUp');
        Route::put('/move-down/{id}', [TestimonialController::class, 'moveDown'])->name('testimonials.moveDown');
    });

    Route::prefix('moments')->group(function () {
        Route::get('/index', [YourMomentController::class, 'index'])->name('moments.index');
        Route::post('/', [YourMomentController::class, 'store'])->name('moments.store');
        Route::delete('/{id}', [YourMomentController::class, 'softDelete'])->name('moments.remove');
        Route::put('/restore/{id}', [YourMomentController::class, 'restoreMoment'])->name('moments.restore');
        Route::delete('/perm-delete/{id}', [YourMomentController::class, 'permDelete'])->name('moments.delete');
        Route::get('/edit/{id}', [YourMomentController::class, 'edit'])->name('moment.edit');
        Route::put('/update/{id}', [YourMomentController::class, 'update'])->name('moment.update');
        Route::put('/move-up/{id}', [YourMomentController::class, 'moveUp'])->name('moments.moveUp');
        Route::put('/move-down/{id}', [YourMomentController::class, 'moveDown'])->name('moments.moveDown');
    });

    Route::prefix('subscribers')->group(function () {
        Route::delete('/{id}', [SubscriberController::class, 'destroy'])->name('subscribers.destroy');
        Route::delete('perm-delete/{id}', [SubscriberController::class, 'permDelete'])->name('subscribers.permDelete');
        Route::put('/restore/{id}', [SubscriberController::class, 'restoreSubscriberWeb'])->name('subscribers.restore');
        Route::put('/send-email', [SubscriberController::class, 'sendEmailToSubscribers'])->name('subscribers.send-email');
    });    

    Route::middleware(['admin'])->group(function () {
        Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');
        Route::get('/get-users', [UserController::class,'getUsers']);
        Route::get('/get-user-details/{userId}', [UserController::class, 'getUserDetails']);

        Route::prefix('admin')->group(function () {    
            Route::get('/register', [AdminRegisterController::class, 'create'])->name('admin.register');
            Route::get('/get-roles', [UserController::class, 'getRoles']);
            Route::get('/get-status-options', [UserController::class, 'getStatusOptions']);
            Route::post('/register', [AdminRegisterController::class, 'store']);
            Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
            Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        });           


    });

});