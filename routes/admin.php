<?php

Route::get('/demo', function () {
    return new App\Mail\AdminResetPassword(rand(100000, 999999));
});

Route::get('/admin', function () {
    return view('admin');
});

Route::prefix('admin-api')->group(function (){
    Route::post('/login', 'Api\Admin\LoginController@login');
    Route::post('/send/mail/reset/password', 'Api\Admin\MailController@resetPassword');
    Route::post('/reset/password/by/mail', 'Api\Admin\AdminController@resetPasswordByMail');
});


Route::prefix('admin-api')
    ->namespace('\App\Http\Controllers\Api\Admin')
    ->middleware(['auth:admin-api'])->group(function () {
        Route::get('/admins/auth', 'AdminController@adminAuth');
        Route::put('/admins/reset/password', 'AdminController@resetPassword');
    });

Route::prefix('admin-api')
    ->namespace('\App\Http\Controllers\Api\Admin')
    ->middleware(['auth:admin-api', 'admin.api.permission'])
    ->group(function () {
        Route::get('/admins/list', 'AdminController@lists');
        Route::post('/admins/create', 'AdminController@create');
        Route::get('/admins/{id}/detail', 'AdminController@detail');
        Route::put('/admins/{id}/update', 'AdminController@update');
        Route::delete('/admins/{id}/delete', 'AdminController@delete');


        Route::get('/menus/list', 'MenuController@lists');
        Route::get('/menus/all', 'MenuController@all');
        Route::get('/menus/all/with/elements', 'MenuController@allWithElements');
        Route::get('/menus/parents', 'MenuController@parents');
        Route::post('/menus/create', 'MenuController@create');
        Route::get('/menus/{id}/detail', 'MenuController@detail');
        Route::put('/menus/{id}/update', 'MenuController@update');
        Route::delete('/menus/{id}/delete', 'MenuController@delete');

        Route::get('/elements/list', 'ElementController@lists');
        Route::post('/elements/create', 'ElementController@create');
        Route::put('/elements/{id}/update', 'ElementController@update');
        Route::get('/elements/{id}/detail', 'ElementController@detail');
        Route::delete('/elements/{id}/delete', 'ElementController@delete');

        Route::get('roles/list', 'RoleController@lists');
        Route::get('/roles/all', 'RoleController@all');
        Route::post('/roles/create', 'RoleController@create');
        Route::put('/roles/{id}/update', 'RoleController@update');
        Route::get('/roles/{id}/detail', 'RoleController@detail');
        Route::delete('/roles/{id}/delete', 'RoleController@delete');
        Route::get('/roles/{id}/auth', 'RoleController@auth');
        Route::post('/roles/{id}/set/auth', 'RoleController@setAuth');
    });


