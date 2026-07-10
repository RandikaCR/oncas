<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

//FRONTEND CONTROLLERS
use App\Http\Controllers\Frontend\FrontendController AS Frontend;

//BACKEND CONTROLLERS
use App\Http\Controllers\Backend\DashboardController AS BackendDashboard;

// B
use App\Http\Controllers\Backend\BattingStylesController AS BackendBattingStyles;
use App\Http\Controllers\Backend\BowlingStylesController AS BackendBowlingStyles;

// I
use App\Http\Controllers\Backend\InternalTeamsController AS BackendInternalTeams;

// P
use App\Http\Controllers\Backend\PaymentStatusesController AS BackendPaymentStatuses;
use App\Http\Controllers\Backend\PlayerLevelsController AS BackendPlayerLevels;
use App\Http\Controllers\Backend\PlayerRolesController AS BackendPlayerRoles;
use App\Http\Controllers\Backend\PlayerStatusesController AS BackendPlayerStatuses;

// S
use App\Http\Controllers\Backend\SchoolsController AS BackendSchools;

// U
use App\Http\Controllers\Backend\UsersController AS BackendUsers;
use App\Http\Controllers\Backend\UserRolesController AS BackendUserRoles;

// V
use App\Http\Controllers\Backend\VenuesController AS BackendVenues;

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

        // B
        Route::get('/batting-styles', [BackendBattingStyles::class, 'index'])->name('backend.battingStyles.index');
        Route::post('/batting-styles/store', [BackendBattingStyles::class, 'store'])->name('backend.battingStyles.store');
        Route::post('/batting-styles/get', [BackendBattingStyles::class, 'get'])->name('backend.battingStyles.get');
        Route::post('/batting-styles/status', [BackendBattingStyles::class, 'status'])->name('backend.battingStyles.status');

        Route::get('/bowling-styles', [BackendBowlingStyles::class, 'index'])->name('backend.bowlingStyles.index');
        Route::post('/bowling-styles/store', [BackendBowlingStyles::class, 'store'])->name('backend.bowlingStyles.store');
        Route::post('/bowling-styles/get', [BackendBowlingStyles::class, 'get'])->name('backend.bowlingStyles.get');
        Route::post('/bowling-styles/status', [BackendBowlingStyles::class, 'status'])->name('backend.bowlingStyles.status');


        // I
        Route::get('/internal-teams', [BackendInternalTeams::class, 'index'])->name('backend.internalTeams.index');
        Route::post('/internal-teams/store', [BackendInternalTeams::class, 'store'])->name('backend.internalTeams.store');
        Route::post('/internal-teams/get', [BackendInternalTeams::class, 'get'])->name('backend.internalTeams.get');
        Route::post('/internal-teams/status', [BackendInternalTeams::class, 'status'])->name('backend.internalTeams.status');


        // P
        Route::get('/payment-statuses', [BackendPaymentStatuses::class, 'index'])->name('backend.paymentStatuses.index');
        Route::post('/payment-statuses/store', [BackendPaymentStatuses::class, 'store'])->name('backend.paymentStatuses.store');
        Route::post('/payment-statuses/get', [BackendPaymentStatuses::class, 'get'])->name('backend.paymentStatuses.get');
        Route::post('/payment-statuses/status', [BackendPaymentStatuses::class, 'status'])->name('backend.paymentStatuses.status');

        Route::get('/player-levels', [BackendPlayerLevels::class, 'index'])->name('backend.playerLevels.index');
        Route::post('/player-levels/store', [BackendPlayerLevels::class, 'store'])->name('backend.playerLevels.store');
        Route::post('/player-levels/get', [BackendPlayerLevels::class, 'get'])->name('backend.playerLevels.get');
        Route::post('/player-levels/status', [BackendPlayerLevels::class, 'status'])->name('backend.playerLevels.status');

        Route::get('/player-roles', [BackendPlayerRoles::class, 'index'])->name('backend.playerRoles.index');
        Route::post('/player-roles/store', [BackendPlayerRoles::class, 'store'])->name('backend.playerRoles.store');
        Route::post('/player-roles/get', [BackendPlayerRoles::class, 'get'])->name('backend.playerRoles.get');
        Route::post('/player-roles/status', [BackendPlayerRoles::class, 'status'])->name('backend.playerRoles.status');

        Route::get('/player-statuses', [BackendPlayerStatuses::class, 'index'])->name('backend.playerStatuses.index');
        Route::post('/player-statuses/store', [BackendPlayerStatuses::class, 'store'])->name('backend.playerStatuses.store');
        Route::post('/player-statuses/get', [BackendPlayerStatuses::class, 'get'])->name('backend.playerStatuses.get');
        Route::post('/player-statuses/status', [BackendPlayerStatuses::class, 'status'])->name('backend.playerStatuses.status');


        // S
        Route::get('/schools', [BackendSchools::class, 'index'])->name('backend.schools.index');
        Route::post('/schools/store', [BackendSchools::class, 'store'])->name('backend.schools.store');
        Route::post('/schools/get', [BackendSchools::class, 'get'])->name('backend.schools.get');
        Route::post('/schools/status', [BackendSchools::class, 'status'])->name('backend.schools.status');


        // U
        Route::get('/my-profile', [BackendUsers::class, 'myProfile'])->name('backend.users.myProfile');
        Route::post('/profile/update-personal-info', [BackendUsers::class, 'saveMyProfilePersonal'])->name('backend.users.saveMyProfilePersonal');

        Route::get('/user-roles', [BackendUserRoles::class, 'index'])->name('backend.userRoles.index');
        Route::post('/user-roles/store', [BackendUserRoles::class, 'store'])->name('backend.userRoles.store');
        Route::post('/user-roles/get', [BackendUserRoles::class, 'get'])->name('backend.userRoles.get');
        Route::post('/user-roles/status', [BackendUserRoles::class, 'status'])->name('backend.userRoles.status');

        // V
        Route::get('/venues', [BackendVenues::class, 'index'])->name('backend.venues.index');
        Route::post('/venues/store', [BackendVenues::class, 'store'])->name('backend.venues.store');
        Route::post('/venues/get', [BackendVenues::class, 'get'])->name('backend.venues.get');
        Route::post('/venues/status', [BackendVenues::class, 'status'])->name('backend.venues.status');

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
