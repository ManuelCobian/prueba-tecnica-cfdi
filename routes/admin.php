<?php

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CfdiController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('dashboard');

Route::get('states/{state}/detail', [HomeController::class, 'detail'])->name('states.detail');

Route::resource('roles', RoleController::class);

Route::resource('users', UserController::class);

Route::get('cfdi/generate',[CfdiController::class, 'generate']
)->name('cfdi.generate');