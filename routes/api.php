<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SkillController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');

});
//Route::resource('skill', [SkillController::class]);
//Route::resource('department', [DepartmentController::class]);
//Route::resource('employee', [EmployeeController::class]);

Route::controller(SkillController::class)->group(function () {
    Route::get('skill', 'index');
    Route::post('skill', 'store');
    Route::get('skill/{skill}', 'show');
    Route::put('skill/{skill}', 'update');
    Route::delete('skill/{skill}', 'destroy');
});
Route::controller(DepartmentController::class)->group(function () {
    Route::get('department', 'index');
    Route::post('department', 'store');
    Route::get('department/{department}', 'show');
    Route::put('department/{department}', 'update');
    Route::delete('department/{department}', 'destroy');
});
Route::controller(EmployeeController::class)->group(function () {
    Route::get('employee', 'index');
    Route::post('employee', 'store');
    Route::get('employee/{employee}', 'show');
    Route::put('employee/{employee}', 'update');
    Route::delete('employee/{employee}', 'destroy');
});




