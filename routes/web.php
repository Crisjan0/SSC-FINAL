<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CollectionController;
use App\Models\Payment;
use App\Models\User;
use App\Models\Course;

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('courses', CourseController::class);

    // Officers / Users endpoints
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/payments/export', [PaymentController::class, 'export'])->name('payments.export');
    Route::post('/payments/import', [PaymentController::class, 'import'])->name('payments.import');
    Route::post('/payments/archive-all', [PaymentController::class, 'archiveAll'])->name('payments.archiveAll');
    Route::get('/payments/archived', [PaymentController::class, 'archived'])->name('payments.archived');
    Route::get('/payments/archived/{batchName}', [PaymentController::class, 'showArchivedBatch'])->name('payments.archived.show');
    Route::post('/payments/archive-batch/restore', [PaymentController::class, 'restoreBatch'])->name('payments.restoreBatch');
    Route::post('/payments/{payment}/restore', [PaymentController::class, 'restore'])->name('payments.restore');
    Route::delete('/payments/{payment}/force-delete', [PaymentController::class, 'forceDelete'])->name('payments.forceDelete');
    Route::resource('payments', PaymentController::class);
    
    Route::get('/collections', [CollectionController::class, 'index'])->name('collections.index');
    Route::get('/collections/{course}', [CollectionController::class, 'show'])->name('collections.show');
});

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    $totalCollection = Payment::sum('amount');
    $transactionCount = Payment::count();
    $usersCount = User::count();
    $courseCount = Course::count();
    $recentPayments = Payment::latest()->take(5)->get();

    return view('dashboard', compact('totalCollection', 'transactionCount', 'usersCount', 'courseCount', 'recentPayments'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
