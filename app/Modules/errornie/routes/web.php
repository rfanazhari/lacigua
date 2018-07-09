<?php

Route::group(['middleware' => ['web']], function () {
    Route::resource('errornie', 'errornieController');
});
