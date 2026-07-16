<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

//FRONTEND CONTROLLERS
use App\Http\Controllers\Frontend\FrontendController AS Frontend;
use App\Http\Controllers\Frontend\PlayersController AS FrontendPlayers;


//BACKEND CONTROLLERS
use App\Http\Controllers\Backend\DashboardController AS BackendDashboard;

// B
use App\Http\Controllers\Backend\BattingStylesController AS BackendBattingStyles;
use App\Http\Controllers\Backend\BowlingStylesController AS BackendBowlingStyles;

// E
use App\Http\Controllers\Backend\EventsController AS BackendEvents;

// I
use App\Http\Controllers\Backend\InternalTeamsController AS BackendInternalTeams;

// P
use App\Http\Controllers\Backend\PaymentStatusesController AS BackendPaymentStatuses;
use App\Http\Controllers\Backend\PlayersController AS BackendPlayers;
use App\Http\Controllers\Backend\PlayerLevelsController AS BackendPlayerLevels;
use App\Http\Controllers\Backend\PlayerRolesController AS BackendPlayerRoles;
use App\Http\Controllers\Backend\PlayerStatusesController AS BackendPlayerStatuses;
use App\Http\Controllers\Backend\PlayerJoinRequestsController AS BackendPlayerJoinRequests;

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

    Route::get('/user/email/verify/{userId}/{expires}/{string}', [Frontend::class, 'verifyUserAccount'])->name('frontend.verifyUserAccount');
    Route::post('/user/email/resend-verification', [Frontend::class, 'sendEmailVerification'])->name('frontend.sendEmailVerification');

    Route::post('/app-logout', [Frontend::class, 'appLogout'])->name('frontend.appLogout');

    Route::get('/test', [Frontend::class, 'test'])->name('frontend.test');
});

//2 - Auth Routes
Route::middleware(['auth', 'verified'])->group(function () {


    // 1.1 - Frontend Auth Routes
    Route::group(['middleware' => ['isAdmin']], function () {

        // P
        Route::get('/player/qr/{userId}', [FrontendPlayers::class, 'qrView'])->name('frontend.players.qrView');
        Route::get('/player/attendances/{userId}', [FrontendPlayers::class, 'attendances'])->name('frontend.players.attendances');
        Route::post('/player/attendances/set-attendance', [FrontendPlayers::class, 'setAttendance'])->name('frontend.players.setAttendance');


    });


    // 2 - Admin Routes
    Route::group([ 'prefix' =>'admin', 'middleware' => ['isAdmin']], function () {

        // D
        Route::get('/', [BackendDashboard::class, 'index'])->name('backend.dashboard');
        Route::post('/set-theme-mode', [BackendDashboard::class, 'setThemeMode'])->name('backend.setThemeMode');

        // B
        Route::get('/batting-styles', [BackendBattingStyles::class, 'index'])->name('backend.battingStyles.index');
        Route::post('/batting-styles/store', [BackendBattingStyles::class, 'store'])->name('backend.battingStyles.store');
        Route::post('/batting-styles/get', [BackendBattingStyles::class, 'get'])->name('backend.battingStyles.get');
        Route::post('/batting-styles/status', [BackendBattingStyles::class, 'status'])->name('backend.battingStyles.status');

        Route::get('/bowling-styles', [BackendBowlingStyles::class, 'index'])->name('backend.bowlingStyles.index');
        Route::post('/bowling-styles/store', [BackendBowlingStyles::class, 'store'])->name('backend.bowlingStyles.store');
        Route::post('/bowling-styles/get', [BackendBowlingStyles::class, 'get'])->name('backend.bowlingStyles.get');
        Route::post('/bowling-styles/status', [BackendBowlingStyles::class, 'status'])->name('backend.bowlingStyles.status');

        // E
        Route::get('/events', [BackendEvents::class, 'index'])->name('backend.events.index');
        Route::get('/event/{eventId}', [BackendEvents::class, 'view'])->name('backend.events.view');
        Route::get('/events/create', [BackendEvents::class, 'create'])->name('backend.events.create');
        Route::get('/events/edit/{userId}', [BackendEvents::class, 'edit'])->name('backend.events.edit');
        Route::post('/events/store', [BackendEvents::class, 'store'])->name('backend.events.store');
        Route::post('/events/status', [BackendEvents::class, 'status'])->name('backend.events.status');
        Route::post('/events/get-players', [BackendEvents::class, 'getPlayers'])->name('backend.events.getPlayers');
        Route::post('/events/set-player-attendance', [BackendEvents::class, 'setAttendance'])->name('backend.events.setAttendance');
        Route::post('/events/set-as-completed', [BackendEvents::class, 'setAsCompleted'])->name('backend.events.setAsCompleted');
        Route::post('/events/get-attendances-via-ajax', [BackendEvents::class, 'getAttendancesViaAjax'])->name('backend.events.getAttendancesViaAjax');


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


        Route::get('/players', [BackendPlayers::class, 'index'])->name('backend.players.index');
        Route::get('/player/{userId}', [BackendPlayers::class, 'view'])->name('backend.players.view');
        Route::get('/players/create', [BackendPlayers::class, 'create'])->name('backend.players.create');
        Route::get('/players/edit/{userId}', [BackendPlayers::class, 'edit'])->name('backend.players.edit');
        Route::post('/players/store', [BackendPlayers::class, 'store'])->name('backend.players.store');
        Route::post('/players/upload-image', [BackendPlayers::class, 'imageUpload'])->name('backend.players.imageUpload');


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

        Route::get('/join-requests', [BackendPlayerJoinRequests::class, 'index'])->name('backend.playerJoinRequests.index');
        Route::post('/join-requests/get', [BackendPlayerJoinRequests::class, 'get'])->name('backend.playerJoinRequests.get');



        // S
        Route::get('/schools', [BackendSchools::class, 'index'])->name('backend.schools.index');
        Route::post('/schools/store', [BackendSchools::class, 'store'])->name('backend.schools.store');
        Route::post('/schools/get', [BackendSchools::class, 'get'])->name('backend.schools.get');
        Route::post('/schools/status', [BackendSchools::class, 'status'])->name('backend.schools.status');


        // U
        Route::get('/users', [BackendUsers::class, 'index'])->name('backend.users.index');
        Route::post('/users/store', [BackendUsers::class, 'store'])->name('backend.users.store');
        Route::post('/users/get', [BackendUsers::class, 'get'])->name('backend.users.get');
        Route::post('/users/status', [BackendUsers::class, 'status'])->name('backend.users.status');

        Route::get('/my-profile', [BackendUsers::class, 'myProfile'])->name('backend.users.myProfile');
        Route::post('/profile/update-personal-info', [BackendUsers::class, 'saveMyProfilePersonal'])->name('backend.users.saveMyProfilePersonal');

        Route::get('/user-roles', [BackendUserRoles::class, 'index'])->name('backend.userRoles.index');
        Route::post('/user-roles/store', [BackendUserRoles::class, 'store'])->name('backend.userRoles.store');
        Route::post('/user-roles/get', [BackendUserRoles::class, 'get'])->name('backend.userRoles.get');
        Route::post('/user-roles/status', [BackendUserRoles::class, 'status'])->name('backend.userRoles.status');
        Route::post('/user-roles/for-select', [BackendUserRoles::class, 'getForSelect'])->name('backend.userRoles.getForSelect');

        // V
        Route::get('/venues', [BackendVenues::class, 'index'])->name('backend.venues.index');
        Route::post('/venues/store', [BackendVenues::class, 'store'])->name('backend.venues.store');
        Route::post('/venues/get', [BackendVenues::class, 'get'])->name('backend.venues.get');
        Route::post('/venues/status', [BackendVenues::class, 'status'])->name('backend.venues.status');

    });

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
