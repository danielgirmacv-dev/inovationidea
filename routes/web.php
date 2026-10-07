<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\IdeaSubmissionController as AdminIdeaSubmissionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IdeaSubmissionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [IdeaSubmissionController::class, 'create'])->name('ideas.create');
Route::get('/submit', [IdeaSubmissionController::class, 'create'])->name('submissions.create');
Route::post('/submit', [IdeaSubmissionController::class, 'store'])->name('submissions.store')
    ->middleware('throttle:10,1'); // 10 submissions per minute rate limit
Route::post('/ideas/store', [IdeaSubmissionController::class, 'store'])->name('ideas.store');

Route::get('/submission/{referenceNumber}/confirmation', [IdeaSubmissionController::class, 'confirmation'])
    ->name('submissions.confirmation');
Route::get('/ideas/{referenceNumber}/confirmation', [IdeaSubmissionController::class, 'confirmation'])
    ->name('ideas.confirmation');

Route::get('/track', [IdeaSubmissionController::class, 'track'])->name('ideas.track');
Route::get('/submissions/track', [IdeaSubmissionController::class, 'track'])->name('submissions.track');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.post')->middleware('throttle:5,1');
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Admin Routes (requires authentication + reviewer/admin role)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:reviewer'])
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Submissions management
        Route::get('/submissions', [AdminIdeaSubmissionController::class, 'index'])->name('submissions.index');
        Route::get('/submissions/export', [AdminIdeaSubmissionController::class, 'export'])->name('submissions.export');
        Route::get('/submissions/{submission}', [AdminIdeaSubmissionController::class, 'show'])->name('submissions.show');
        Route::patch('/submissions/{submission}/status', [AdminIdeaSubmissionController::class, 'updateStatus'])->name('submissions.updateStatus');
        Route::patch('/submissions/{submission}/update-status', [AdminIdeaSubmissionController::class, 'updateStatus'])->name('submissions.update-status');
        Route::patch('/submissions/{submission}/reviewer', [AdminIdeaSubmissionController::class, 'assignReviewer'])->name('submissions.assignReviewer');
        Route::patch('/submissions/{submission}/assign-reviewer', [AdminIdeaSubmissionController::class, 'assignReviewer'])->name('submissions.assign-reviewer');
        Route::post('/submissions/{submission}/comments', [AdminIdeaSubmissionController::class, 'addComment'])->name('submissions.addComment');
        Route::post('/submissions/{submission}/add-comment', [AdminIdeaSubmissionController::class, 'addComment'])->name('submissions.add-comment');
        Route::delete('/submissions/{submission}', [AdminIdeaSubmissionController::class, 'destroy'])->name('submissions.destroy');

        // Categories (admin only)
        Route::middleware('role:admin')->group(function () {
            Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
            Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
            Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
            Route::patch('/categories/{category}/toggle', [CategoryController::class, 'toggleActive'])->name('categories.toggle');

            // Users
            Route::get('/users', [UserController::class, 'index'])->name('users.index');
            Route::post('/users', [UserController::class, 'store'])->name('users.store');
            Route::patch('/users/{user}/toggle', [UserController::class, 'toggleActive'])->name('users.toggle');
            Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
            Route::patch('/users/{user}/update-role', [UserController::class, 'updateRole'])->name('users.update-role');
            Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        });
    });
