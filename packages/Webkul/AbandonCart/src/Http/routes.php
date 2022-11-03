<?php

Route::group(['middleware' => ['web', 'abandoncart']], function () {
    Route::prefix('admin')->group(function () {
        Route::prefix('sales')->group(function () {

            // Sales Order Routes
            Route::get('/abandon-cart', 'Webkul\AbandonCart\Http\Controllers\Admin\AbandonCartController@index')->defaults('_config', [
                'view' => 'abandoncart::admin.customers.abandoncart.index'
            ])->name('admin.customers.abandon-cart.index');

            Route::get('/abandon-cart/{id}', 'Webkul\AbandonCart\Http\Controllers\Admin\AbandonCartController@show')->defaults('_config', [
                'view' => 'abandoncart::admin.customers.abandoncart.view'
            ])->name('admin.customers.abandon-cart.view');

            Route::get('abandon-cart/mail/{id}', 'Webkul\AbandonCart\Http\Controllers\Admin\AbandonCartController@sendMail')->name('admin.sales.abandon-cart.mail');

        });
    });
});