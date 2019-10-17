<?php

Route::post('login', 'Admin\Api\LoginController@login');

Route::middleware('auth:admin-api')->group(function() {
    Route::get('/admins/list', 'Admin\Api\AdminsApiController@lists');
    Route::delete('/admins/delete', 'Admin\Api\AdminsApiController@delete');
});
