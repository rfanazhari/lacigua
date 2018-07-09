<?php

Route::group(['middleware' => ['web']], function () {
    Route::resource('api', 'apiController');
});
