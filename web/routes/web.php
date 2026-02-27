<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});


use App\Http\Controllers\AdminController;

Route::middleware(['auth', \App\Http\Middleware\CheckBanned::class])->group(function () {
    Route::get('/invitation', [InvitationController::class, 'accept'])->name('invitations.accept');

    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/colocations', [ColocationController::class, 'index'])->name('colocations.index');
    Route::get('/colocations/create', [ColocationController::class, 'create'])->name('colocations.create');
    Route::middleware([\App\Http\Middleware\CheckColocationMembership::class])->group(function () {
        Route::get('/colocations/{colocation}', [ColocationController::class, 'show'])->name('colocations.show');
        Route::post('/colocations/{colocation}/leave', [ColocationController::class, 'leave'])->name('colocations.leave');
        Route::post('/colocations/{colocation}/cancel', [ColocationController::class, 'cancel'])->name('colocations.cancel');
        Route::post('/colocations/{colocation}/kick/{user}', [ColocationController::class, 'kick'])->name('colocations.kick');
        Route::post('/colocations/{colocation}/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::delete('/colocations/{colocation}/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    });
    Route::post('/colocations', [ColocationController::class, 'store'])->name('colocations.store');
    Route::post('/colocations/{colocation}/expenses', [ExpenseController::class, 'store'])->name('expenses.store')->middleware([\App\Http\Middleware\CheckColocationMembership::class]);
    Route::post('/payments/{payment}/pay', [PaymentController::class, 'pay'])->name('payments.pay');
    Route::post('/invitations', [InvitationController::class, 'sendInvitation'])->name('invitations.send');
    Route::post('/invitations/join', [InvitationController::class, 'join'])->name('invitations.join');
    Route::post('/invitations/decline', [InvitationController::class, 'decline'])->name('invitations.decline');

    Route::middleware([\App\Http\Middleware\IsAdmin::class])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::post('/admin/users/{user}/ban', [AdminController::class, 'ban'])->name('admin.users.ban');
        Route::post('/admin/users/{user}/unban', [AdminController::class, 'unban'])->name('admin.users.unban');
    });
});

require __DIR__.'/auth.php';
