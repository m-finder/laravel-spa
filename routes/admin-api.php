<?php

Route::post('login', 'Api\Admin\LoginController@login');

Route::middleware('auth:admin-api')->group(function() {
    Route::get('/admins/list', 'Api\Admin\AdminController@lists');
    Route::get('/admins/{id}/detail', 'Api\Admin\AdminController@detail');
    Route::delete('/admins/{id}/delete', 'Api\Admin\AdminController@delete');

    Route::get('/roles/list', 'Api\Admin\RoleController@lists');
    Route::get('/roles/{id}/detail', 'Api\Admin\RoleController@detail');
    Route::put('/roles/{id}/update', 'Api\Admin\RoleController@update');
    Route::post('/roles/create', 'Api\Admin\RoleController@create');
    Route::delete('/roles/{id}/delete', 'Api\Admin\RoleController@delete');
});
