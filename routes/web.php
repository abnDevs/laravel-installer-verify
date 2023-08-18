<?php

use AbnDevs\Installer\Http\Controllers\AdminController;
use AbnDevs\Installer\Http\Controllers\DatabaseController;
use AbnDevs\Installer\Http\Controllers\InstallController;
use AbnDevs\Installer\Http\Controllers\PermissionController;
use AbnDevs\Installer\Http\Controllers\RequirementController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => config('installer.prefix', 'installer'),
    'as' => 'installer.',
    'middleware' => ['web', 'installed'],
    'excluded_middleware' => ['install', 'licensed'],
], function () {
    Route::get('/', [InstallController::class, 'index'])->name('agreement.index');
    Route::post('/', [InstallController::class, 'store'])->name('agreement.store');

    Route::get('requirements', [RequirementController::class, 'index'])->name('requirements.index');
    Route::post('requirements', [RequirementController::class, 'store'])->name('requirements.store');

    Route::get('permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::post('permissions', [PermissionController::class, 'store'])->name('permissions.store');

    Route::get('database', [DatabaseController::class, 'index'])->name('database.index');
    Route::post('database', [DatabaseController::class, 'store'])->name('database.store');

    Route::get('admin', [AdminController::class, 'index'])->name('admin.index');
    Route::post('admin', [AdminController::class, 'store'])->name('admin.store');

    Route::get('finish', [InstallController::class, 'finish'])->name('finish.index');
});
