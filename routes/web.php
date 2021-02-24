<?php

Route::group(['namespace' => 'Subash\Esewa\Http\Controllers', 'middleware' => ['web', 'core']], function () {
    Route::get('esewa/payment/success', [
        'as'   => 'esewa.payment.success',
        'uses' => 'EsewaController@paymentSuccess',
    ]);
    Route::get('esewa/payment/failure', [
        'as'   => 'esewa.payment.failure',
        'uses' => 'EsewaController@paymentFailure',
    ]);
});