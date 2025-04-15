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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('report', ReportController::class);
Route::get('/reports/search', [ReportController::class, 'search'])->name('report.search');


Route::middleware(['auth', 'role:HEAD_STAFF'])->group(function () {
    Route::resource('staff-management', StaffManagementController::class);
});

Route::get('/reports/export', [ReportController::class, 'export'])->name('report.export');
Route::get('/reports/{id}/export', [ReportController::class, 'exportSingle'])->name('report.exportSingle');
Route::get('/reports/export-by-date', [ReportController::class, 'exportByDate'])->name('report.exportByDate');
// Route::get('/admin-dashboard', function () {
//     return view('admin.dashboard');
// })->middleware('role:admin')

require __DIR__.'/auth.php';
