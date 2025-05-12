<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnnouncementController;
use App\Models\Announcement;
use App\Models\Category;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Inertia\Inertia;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
Route::get('/announcements',[AnnouncementController ::class, 'index'])->name('announcements.index');
Route::get('/announcements/create',[AnnouncementController ::class, 'create'])->name('announcements.create');
Route::post('/announcements/create',[AnnouncementController::class,'store'])->name ('announcements.store');
Route::get('/announcements/edit/{id}',[AnnouncementController::class,'edit'])->name('announcements.edit');
Route::post('/announcements/edit/{id}',[AnnouncementController::class,'update'])->name('announcements.update');
Route::post('/announcements/delete/{id}',[AnnouncementController::class,'destroy'])->name('announcements.destroy');
Route::get('/announcements/{id}',[AnnouncementController::class,'show'])->name('announcements.show');
Route::post('/announcements/category',[AnnouncementController::class,'getByCategory'])->name('announcements.by.category');
});


require __DIR__.'/auth.php';
