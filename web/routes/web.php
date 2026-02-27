<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvitationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});



Route::middleware('auth')->group(function () {
    Route::get('/invitation', [InvitationController::class, 'accept'])->name('invitations.accept');

    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/colocations', [ColocationController::class, 'index'])->name('colocations.index');
    Route::get('/colocations/create', [ColocationController::class, 'create'])->name('colocations.create');
    Route::get('/colocations/{colocation}', [ColocationController::class, 'show'])->name('colocations.show');
    Route::post('/colocations/{colocation}/leave', [ColocationController::class, 'leave'])->name('colocations.leave');
    Route::post('/colocations/{colocation}/cancel', [ColocationController::class, 'cancel'])->name('colocations.cancel');
    Route::post('/colocations', [ColocationController::class, 'store'])->name('colocations.store');
    Route::post('/invitations', [InvitationController::class, 'sendInvitation'])->name('invitations.send');
    Route::post('/invitations/join', [InvitationController::class, 'join'])->name('invitations.join');
});

require __DIR__.'/auth.php';
