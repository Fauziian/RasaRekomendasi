<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\User\UserHomeController;
use App\Http\Controllers\User\UserRecipeController;
use App\Http\Controllers\User\UserRecommendationController;
use App\Http\Controllers\User\UserVipController;
use App\Http\Controllers\User\UserConsultationController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminRecipeController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminModerationController;
use App\Http\Controllers\Admin\AdminTransactionController;
use App\Http\Controllers\Chef\ChefDashboardController;
use App\Http\Controllers\Chef\ChefRecipeController;
use App\Http\Controllers\Chef\ChefScheduleController;
use App\Http\Controllers\Chef\ChefConsultationController;

// ─────────────────────────────────────────────
// 🔹 Public Route
// ─────────────────────────────────────────────
Route::get('/', [UserHomeController::class, 'index'])->name('welcome');

// ─────────────────────────────────────────────
// 🔹 Protected Routes
// ─────────────────────────────────────────────
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Recipes
    Route::get('/recipes', [UserRecipeController::class, 'index'])->name('recipes.index');
    Route::get('/recipes/{recipe:slug}', [UserRecipeController::class, 'show'])->name('recipes.show');
    Route::post('/recipes/{recipe}/rate', [UserRecipeController::class, 'rate'])->name('recipes.rate');
    Route::post('/recipes/{recipe}/save', [UserRecipeController::class, 'save'])->name('recipes.save');

    // Recommendation AI Wizard
    Route::get('/recommendations', [UserRecommendationController::class, 'index'])->name('recommendations.index');
    Route::post('/recommendations/results', [UserRecommendationController::class, 'results'])->name('recommendations.results');

    // VIP Area
    Route::get('/vip', [UserVipController::class, 'index'])->name('vip.index');
    Route::get('/vip/checkout/{package}', [UserVipController::class, 'checkout'])->name('vip.checkout');
    Route::post('/vip/checkout/{package}/process', [UserVipController::class, 'processCheckout'])->name('vip.checkout.process');

    // VIP Live Consultations (Only for VIP Users)
    Route::middleware(['vip'])->group(function () {
        Route::get('/consultations', [UserConsultationController::class, 'index'])->name('consultations.index');
        Route::get('/consultations/create/{chef}', [UserConsultationController::class, 'create'])->name('consultations.create');
        Route::post('/consultations/store/{chef}', [UserConsultationController::class, 'store'])->name('consultations.store');
        Route::get('/consultations/{consultation}/chat', [UserConsultationController::class, 'chat'])->name('consultations.chat');
        Route::post('/consultations/{consultation}/message', [UserConsultationController::class, 'sendMessage'])->name('consultations.message');
    });

    // ─────────────────────────────────────────────
    // 🔹 ADMIN routes
    // ─────────────────────────────────────────────
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/statistics', [AdminDashboardController::class, 'statistics'])->name('statistics');
        
        Route::resource('recipes', AdminRecipeController::class);
        Route::resource('categories', AdminCategoryController::class);
        Route::resource('users', AdminUserController::class);
        
        Route::get('/moderation', [AdminModerationController::class, 'index'])->name('moderation.index');
        Route::patch('/moderation/{comment}/approve', [AdminModerationController::class, 'approve'])->name('moderation.approve');
        Route::delete('/moderation/{comment}', [AdminModerationController::class, 'destroy'])->name('moderation.destroy');
        
        Route::get('/transactions', [AdminTransactionController::class, 'index'])->name('transactions.index');
    });

    // ─────────────────────────────────────────────
    // 🔹 CHEF routes
    // ─────────────────────────────────────────────
    Route::middleware(['role:chef'])->prefix('chef')->name('chef.')->group(function () {
        Route::get('/', [ChefDashboardController::class, 'index'])->name('dashboard');
        
        Route::resource('recipes', ChefRecipeController::class);
        Route::resource('schedules', ChefScheduleController::class);
        
        Route::get('/consultations', [ChefConsultationController::class, 'index'])->name('consultations.index');
        Route::get('/consultations/{consultation}/chat', [ChefConsultationController::class, 'chat'])->name('chef.consultations.chat');
        Route::get('/consultations/{consultation}/room', [ChefConsultationController::class, 'chat'])->name('consultations.chat');
        Route::post('/consultations/{consultation}/message', [ChefConsultationController::class, 'sendMessage'])->name('consultations.message');
    });
});

require __DIR__.'/auth.php';