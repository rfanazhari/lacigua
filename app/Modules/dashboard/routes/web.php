<?php

Route::group(['middleware' => ['web']], function () {
    Route::resource('dashboard', 'dashboardController');
});
