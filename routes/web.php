<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('survey')
    ->controller(SurveyController::class)
    ->as('survey.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/lookup', 'lookup')->name('lookup');
        Route::post('/submit', 'submit')->name('submit');
    });

Route::get('/', function () {
    return redirect()->route('survey.index');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login-form');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::prefix('user')
        ->controller(UserController::class)
        ->as('users.')
        ->group(function () {
            Route::get('/index', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{user}', 'edit')->name('edit');
            Route::post('/update/{user}', 'update')->name('update');
            Route::delete('/delete/{user}', 'delete')->name('delete');

            Route::post('birthday-sms', 'sendBirthDaySms')->name('send-birth-day-sms');
            Route::get('/survey/{user}', 'survey')->name('survey');
        });

    Route::prefix('cities')
        ->controller(CityController::class)
        ->as('cities.')
        ->group(function () {
            Route::get('/index', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{city}', 'edit')->name('edit');
            Route::post('/update/{city}', 'update')->name('update');
            Route::delete('/delete/{city}', 'delete')->name('delete');
            Route::get('/by-province/{province}', 'byProvince')->name('by-province');
        });

    Route::prefix('provinces')
        ->controller(ProvinceController::class)
        ->as('provinces.')
        ->group(function () {
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{province}', 'edit')->name('edit');
            Route::post('/update/{province}', 'update')->name('update');
            Route::delete('/delete/{province}', 'delete')->name('delete');
        });

    Route::prefix('questions')
        ->controller(QuestionController::class)
        ->as('questions.')
        ->group(function () {
            Route::get('/index', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{question}', 'edit')->name('edit');
            Route::post('/update/{question}', 'update')->name('update');
            Route::delete('/delete/{question}', 'delete')->name('delete');

            Route::post('/answer/{answer}', 'updateAnswer')->name('answer.update');
            Route::delete('/answer/{answer}', 'deleteAnswer')->name('answer.delete');
        });

});
