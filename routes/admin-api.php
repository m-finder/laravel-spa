<?php

Route::post('login', 'Api\Admin\LoginController@login');

Route::middleware('auth:admin-api')->group(function() {
    Route::get('/admins/list', 'Api\Admin\AdminsApiController@lists');
    Route::delete('/admins/delete', 'Api\Admin\AdminsApiController@delete');
});
