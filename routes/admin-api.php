<?php

Route::post('login', 'Api\Admin\LoginController@login');

Route::middleware('auth:admin-api')->group(function() {
    Route::get('/admins/list', 'Api\Admin\AdminController@lists');
    Route::delete('/admins/delete', 'Api\Admin\AdminController@delete');

    Route::get('/roles/list', 'Api\Admin\RoleController@lists');
    Route::get('/roles/detail', 'Api\Admin\RoleController@detail');
    Route::put('/roles/{id}/update', 'Api\Admin\RoleController@update');
    Route::post('/roles/create', 'Api\Admin\RoleController@create');
});
