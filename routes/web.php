<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PositionsController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::prefix('employees')->as('employees.')->group(function () {
        Route::get('/', [EmployeesController::class, 'datatables'])->name('datatables');
        Route::get('/add', [EmployeesController::class, 'add'])->name('add');
        Route::post('/add', [EmployeesController::class, 'create'])->name('create');
        Route::delete('/{id}', [EmployeesController::class, 'delete'])->name('delete');
        Route::get('/{id}', [EmployeesController::class, 'edit'])->name('edit');
        Route::post('/{id}', [EmployeesController::class, 'update'])->name('update');

    });

    Route::prefix('positions')->as('positions.')->group(function () {
        Route::get('/', [PositionsController::class, 'datatables'])->name('datatables');
        Route::get('/add', [PositionsController::class, 'add'])->name('add');
        Route::post('/add', [PositionsController::class, 'create'])->name('create');
        Route::delete('/{id}', [PositionsController::class, 'delete'])->name('delete');
        Route::get('/{id}', [PositionsController::class, 'edit'])->name('edit');
        Route::post('/{id}', [PositionsController::class, 'update'])->name('update');
    });
});


