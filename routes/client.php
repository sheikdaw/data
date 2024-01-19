<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FormController;
use App\Http\Middleware\PreventBackHistory;

Route::prefix('client')->name('client.')->group(function () {
    Route::middleware(['guest:client', PreventBackHistory::class])->group(function () {
        Route::view('/login', 'back.page.client.auth.login')->name('login');
        Route::post('/login_handler', [ClientController::class, 'loginHandler'])->name('login_handler');
        Route::view('/loforgot-passwordgin', 'back.page.admin.auth.forgot-password')->name('forgot-password');
        Route::post('/send-password-reset-link', [ClientController::class, 'sendpasswordresetlink'])->name('send-password-reset-link');
        Route::view('/password/reset/{token}', 'back.page.admin.auth.resetPassword')->name('reset-password');
    });

    Route::middleware(['auth:client', PreventBackHistory::class])->group(function () {
        Route::get('/home', [ClientController::class, 'home'])->name('home');
        Route::post('/logout_handler', [ClientController::class, 'logoutHandler'])->name('logout_handler');
        Route::get('/profile', [ClientController::class, 'profileView'])->name('profile');
        Route::post('/change-profile-picture', [ClientController::class, 'changeProfilePicture'])->name('change-profile-picture');
        Route::get('/admin/get-profile-picture', [ClientController::class, 'getProfilePicture'])->name('get-profile-picture');
        Route::view('/survey-gis', 'back.page.client.survey-gis')->name('Survey-Gis');
        Route::post('/survey-form', [ClientController::class, 'surveyForm'])->name('Survey-Form');
        Route::post('/form-property', [FormController::class, 'property'])->name('form-property');
        Route::post('/form-address', [FormController::class, 'address'])->name('form-address');
        Route::post('/form-floor', [FormController::class, 'floor'])->name('form-floor');
        Route::post('/form-establishment', [FormController::class, 'establishment'])->name('form-establishment');
        Route::post('/form-submit', [FormController::class, 'formsubmit'])->name('form-submit');
        Route::post('/gis-update', [FormController::class, 'gisUpdate'])->name('gis-Update');
        Route::post('/gis-images-upload', [ClientController::class, 'storeimg'])->name('gis-images-upload');
    });
});


