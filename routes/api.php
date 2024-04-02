<?php

use App\Http\Controllers\PlanController;
use Illuminate\Support\Facades\Route;

Route::controller(PlanController::class)
    ->prefix('plans')
    ->group(function () {
        Route::get('/', 'list')->name('plans.list');
        //Route::post('/', 'store')->name('plans.store');
        //Route::post('{id}', 'show')->name('plans.show');
        //Route::patch('{id}', 'update')->name('plans.update');
        //Route::delete('{id}', 'delete')->name('plans.delete');
    });
