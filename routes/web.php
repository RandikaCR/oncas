<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

//FRONTEND CONTROLLERS
use App\Http\Controllers\Frontend\FrontendController AS Frontend;

//BACKEND CONTROLLERS
use App\Http\Controllers\Backend\DashboardController AS BackendDashboard;

//1 - Frontend Routes
Route::group([ 'prefix' =>'/'], function () {
    Route::get('/', [Frontend::class, 'index'])->name('frontend.homepage');
    Route::get('/contact', [Frontend::class, 'contactUs'])->name('frontend.contactUs');
    Route::get('/join-academy', [Frontend::class, 'joinAcademy'])->name('frontend.joinAcademy');
    Route::post('/set-join-academy', [Frontend::class, 'setJoinAcademy'])->name('frontend.setJoinAcademy');

    Route::post('/app-logout', [Frontend::class, 'appLogout'])->name('frontend.appLogout');

    Route::get('/test', [Frontend::class, 'test'])->name('frontend.test');
});

//2 - Auth Routes
Route::middleware(['auth', 'verified'])->group(function () {

    //2 - Admin Routes
    Route::group([ 'prefix' =>'admin', 'middleware' => ['isAdmin']], function () {

        // D
        Route::get('/', [BackendDashboard::class, 'index'])->name('backend.dashboard');


        // E
        /*Route::get('/event-categories', [BackendEventCategories::class, 'index'])->name('backend.eventCategories.index');
        Route::post('/event-categories/store', [BackendEventCategories::class, 'store'])->name('backend.eventCategories.store');
        Route::post('/event-categories/get', [BackendEventCategories::class, 'get'])->name('backend.eventCategories.get');
        Route::post('/event-categories/status', [BackendEventCategories::class, 'status'])->name('backend.eventCategories.status');
        Route::post('/event-categories/slug-generator', [BackendEventCategories::class, 'slugGenerator'])->name('backend.eventCategories.slugGenerator');*/


    });


    // 3 - Other Routes
    /*Route::group([ 'prefix' =>'reservations', 'middleware' => ['isReservationsManager']], function () {
        Route::get('/', [BackendDashboard::class, 'index'])->name('backend.dashboard');
    });*/


});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
