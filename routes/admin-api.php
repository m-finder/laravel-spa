<?php

Route::post('login', 'Api\Admin\LoginController@login');

Route::middleware('auth:admin-api')->group(function() {
    Route::get('/admins/list', 'Api\Admin\AdminController@lists');
    Route::post('/admins/create', 'Api\Admin\AdminController@create');
    Route::get('/admins/{id}/detail', 'Api\Admin\AdminController@detail');
    Route::put('/admins/{id}/update', 'Api\Admin\AdminController@update');
    Route::delete('/admins/{id}/delete', 'Api\Admin\AdminController@delete');

    Route::get('/menus/list', 'Api\Admin\MenuController@lists');
    Route::get('/menus/all', 'Api\Admin\MenuController@all');
    Route::get('/menus/parents', 'Api\Admin\MenuController@parents');
    Route::post('/menus/create', 'Api\Admin\MenuController@create');
    Route::get('/menus/{id}/detail', 'Api\Admin\MenuController@detail');
    Route::put('/menus/{id}/update', 'Api\Admin\MenuController@update');
    Route::delete('/menus/{id}/delete', 'Api\Admin\MenuController@delete');

    Route::get('/elements/list', 'Api\Admin\ElementController@lists');
    Route::post('/elements/create', 'Api\Admin\ElementController@create');
    Route::put('/elements/{id}/update', 'Api\Admin\ElementController@update');
    Route::get('/elements/{id}/detail', 'Api\Admin\ElementController@detail');
    Route::delete('/elements/{id}/delete', 'Api\Admin\ElementController@delete');

    Route::get('/roles/list', 'Api\Admin\RoleController@lists');
    Route::get('/roles/all', 'Api\Admin\RoleController@all');
    Route::post('/roles/create', 'Api\Admin\RoleController@create');
    Route::put('/roles/{id}/update', 'Api\Admin\RoleController@update');
    Route::get('/roles/{id}/detail', 'Api\Admin\RoleController@detail');
    Route::delete('/roles/{id}/delete', 'Api\Admin\RoleController@delete');
});
