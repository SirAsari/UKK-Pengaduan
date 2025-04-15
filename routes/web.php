<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffManagementController;

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

// Buat Guest
// show the user report index page
route::get('', [ReportController::class,'userIndex'])->name('user.reports');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/reports/search', [ReportController::class, 'search'])->name('report.search');
});

// Buat User
Route::middleware(['auth', 'role:USER'])->group(function () {
    Route::post('/user-reports/{id}/vote', [ReportController::class, 'vote'])->name('report.vote');
    Route::get('/user-reports', [ReportController::class, 'userIndex'])->name('user.reports');
    Route::get('/user-reports/{id}', [ReportController::class, 'userShow'])->name('user.report.show');
    Route::post('/user-reports/{id}/comment', [ReportController::class, 'addComment'])->name('report.comment');
    Route::get('/user-reports-create', [ReportController::class, 'userCreate'])->name('user.report.create');
    Route::post('/user-reports', [ReportController::class, 'store'])->name('user.report.store');
});

// Buat STAFF and HEAD_STAFF
Route::middleware(['auth', 'role:STAFF,HEAD_STAFF'])->group(function () {
    Route::post('/reports/{id}/update-status', [ReportController::class, 'updateStatus'])->name('report.updateStatus');
    Route::resource('report', ReportController::class);
    Route::get('/reports/export', [ReportController::class, 'export'])->name('report.export');
    Route::get('/reports/{id}/export', [ReportController::class, 'exportSingle'])->name('report.exportSingle');
    Route::get('/reports/export-by-date', [ReportController::class, 'exportByDate'])->name('report.exportByDate');
});

// Buat HEAD_STAFF
Route::middleware(['auth', 'role:HEAD_STAFF'])->group(function () {
    Route::get('/staff-dashboard', action: [ReportController::class, 'headStaffDashboard'])->name('head-staff.dashboard');
    Route::resource('staff-management', StaffManagementController::class);
});

Route::get('/admin-dashboard', function () {
    return view('admin.dashboard');
})->middleware('role:admin');

require __DIR__.'/auth.php';
