<?php

use Illuminate\Support\Facades\Route;

use Webkul\Notification\Http\Controllers\Admin\FcmController;

/**
 * Catalog routes.
 */
Route::post('/fcms/device_token',
    [\Webkul\Notification\Http\Controllers\Admin\DeviceTokenController::class, 'store'])->middleware("web")
    ->name('admin.notifications.device_token.store');

Route::group(['middleware' => ['web', 'admin'], 'prefix' => 'admin'], function () {

    Route::get('/fcms', [FcmController::class, 'index'])->defaults('_config', [
        'view' => 'fcm::fcm.index',
    ])->name('admin.notifications.fcm.index');


    Route::get('/fcms/create', [FcmController::class, 'create'])->defaults('_config', [
        'view' => 'fcm::fcm.create',
    ])->name('admin.notifications.fcm.create');


    Route::get('/fcms/edit/{id}', [FcmController::class, 'edit'])->defaults('_config', [
        'view' => 'fcm::fcm.edit',
    ])->name('admin.notifications.fcm.edit');

    Route::put('/fcms/edit/{id}', [FcmController::class, 'update'])->defaults('_config', [
        'redirect' => 'admin.notifications.fcm.index',
    ])->defaults('send', false)->name('admin.notifications.fcm.update');

    Route::put('/fcms/send/{id}', [FcmController::class, 'update'])->defaults('_config', [
        'redirect' => 'admin.notifications.fcm.index',
    ])->defaults('send', true)->name('admin.notifications.fcm.send');


    Route::post('/fcms/create', [FcmController::class, 'store'])->defaults('_config', [
        'redirect' => 'admin.notifications.fcm.index',
    ])->name('admin.notifications.fcm.store');

//         Route::put('/fcms/edit/{id}', [FcmController::class, 'update'])->defaults('_config', [
//             'redirect' => 'admin.notification.fcm.index',
//         ])->name('admin.notifications.fcm.update');


    Route::post('/fcms/delete/{id}', [FcmController::class, 'destroy'])->name('admin.notifications.fcm.delete');


});
