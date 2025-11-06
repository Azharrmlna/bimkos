<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminKonselingController;
use App\Http\Controllers\Admin\AdminArticleController;
use App\Http\Controllers\Admin\AdminAgendaController;
use App\Http\Controllers\Admin\AdminMessageController;
use App\Http\Controllers\Siswa\SiswaDashboardController;
use App\Http\Controllers\Siswa\SiswaKonselingController;
use App\Http\Controllers\Siswa\SiswaMessageController;
use App\Http\Controllers\Siswa\SiswaProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;


// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Public Routes
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/articles', [PublicController::class, 'articles'])->name('articles.index');
Route::get('/articles/{slug}', [PublicController::class, 'articleShow'])->name('articles.show');
Route::get('/agendas', [PublicController::class, 'agendas'])->name('agendas.index');
Route::get('/contact', [PublicController::class, 'contact'])->name('contact');
Route::post('/contact', [PublicController::class, 'contactStore'])->name('contact.store');


// Admin Routes (Guru BK)
Route::middleware(['auth', 'guru_bk'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Konseling Management
    Route::resource('konseling', AdminKonselingController::class)->except(['create', 'store', 'edit']);
    
    // Article Management
    Route::resource('articles', AdminArticleController::class);
    
    // Agenda Management
    Route::resource('agendas', AdminAgendaController::class);
    
    // Chat/Messages
    Route::get('/messages', [AdminMessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{siswa}', [AdminMessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{siswa}', [AdminMessageController::class, 'store'])->name('messages.store');
    Route::get('/api/messages/{siswa}', [AdminMessageController::class, 'getMessages'])->name('messages.get');
});

// Siswa Routes
Route::middleware(['auth', 'siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');
    
    // Konseling
    Route::resource('konseling', SiswaKonselingController::class);
    
    // Messages
    Route::get('/messages', [SiswaMessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{guruBk}', [SiswaMessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{guruBk}', [SiswaMessageController::class, 'store'])->name('messages.store');
    Route::get('/api/messages/{guruBk}', [SiswaMessageController::class, 'getMessages'])->name('messages.get');
    
    // Profile
    Route::get('/profile', [SiswaProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [SiswaProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [SiswaProfileController::class, 'updatePassword'])->name('profile.password');
});