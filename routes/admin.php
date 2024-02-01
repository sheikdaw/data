<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\PreventBackHistory;

Route::get("/gisid/{id}", [AdminController::class, 'showqr']);
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['guest:admin', PreventBackHistory::class])->group(function () {
        Route::view('/login', 'back.page.admin.auth.login')->name('login');
        Route::get("/home",[AdminController::class,'home'])->name('home');
        Route::post('/login_handler', [AdminController::class, 'loginHandler'])->name('login_handler');
        Route::view('/forgot-password', 'back.page.admin.auth.forgot')->name('forgot-password');
        Route::post('/send-password-reset-link', [AdminController::class, 'sendpasswordresetlink'])->name('send-password-reset-link');
        Route::view('/password/reset/{token}', 'back.page.admin.auth.resetPassword')->name('reset-password');
    });

    Route::middleware(['auth:admin', PreventBackHistory::class])->group(function () {
        Route::get("/home",[AdminController::class,'home'])->name('home');
        Route::post('/logout_handler', [AdminController::class, 'logoutHandler'])->name('logout_handler');
        Route::get('/profile', [AdminController::class, 'profileView'])->name('profile');
        Route::post('/change-profile-picture', [AdminController::class, 'changeProfilePicture'])->name('change-profile-picture');
        Route::get('/admin/get-profile-picture', [AdminController::class, 'getProfilePicture'])->name('get-profile-picture');
        Route::get('/upload-exel',[AdminController::class,'uploadExel'])->name('uploadExel');
        Route::post('/upload-form/fileupload',[AdminController::class,'upload'])->name('uploadusers');
        Route::post('/export-pdf', [AdminController::class,'exportPdf'])->name('export-pdf');
        Route::get('admin/download-pdf', [AdminController::class, 'downloadPdf'])->name('download-pdf');
        Route::get('admin/client-view', [AdminController::class, 'clientView'])->name('client-view');
        Route::get('/clients/{id}/edit', [AdminController::class,'clientEdit'])->name('client-edit-view');
        Route::post('/change-client-profile-picture', [AdminController::class, 'changeClientProfilePicture'])->name('change-client-profile-picture');
        Route::post('/admin/get-client-profile-picture', [AdminController::class, 'getClientProfilePicture'])->name('get-client-profile-picture');
    });
});

