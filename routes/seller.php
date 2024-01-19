<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SellerController;
use App\Http\Middleware\PreventBackHistory;

Route::prefix('seller')->name('seller.')->group(function () {
    Route::middleware(['guest:seller', PreventBackHistory::class])->group(function () {
        Route::view('/login', 'back.page.seller.auth.login')->name('login');
        Route::post('/login_handler', [SellerController::class, 'loginHandler'])->name('login_handler');
    });

    Route::middleware(['auth:seller', PreventBackHistory::class])->group(function () {
        Route::get('/home', [SellerController::class, 'home'])->name('home');
        Route::post('/logout_handler', [SellerController::class, 'logoutHandler'])->name('logout_handler');
        Route::get('/profile', [SellerController::class, 'profileView'])->name('profile');
        Route::post('/change-profile-picture', [SellerController::class, 'changeProfilePicture'])->name('change-profile-picture');
        Route::get('/seller/get-profile-picture', [SellerController::class, 'getProfilePicture'])->name('get-profile-picture');
        Route::get('/seller/show-all-survey-data', [SellerController::class, 'showAllSurveyData'])->name('show-all-survey-data');
        Route::get('/seller/show-particular-survey-data', [SellerController::class, 'showParticularSurveyData'])->name('show-particular-survey-data');
        
    });
});
