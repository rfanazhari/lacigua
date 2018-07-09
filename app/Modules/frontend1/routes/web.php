<?php

Route::group(['middleware' => ['web']], function () {
    Route::resource('frontend1', 'frontend1Controller');
});
