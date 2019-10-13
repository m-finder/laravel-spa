<?php

# spa 后台，整站 spa 去掉外层 admin
Route::prefix('admin')->group(function() {
    Route::get('/', 'Admin\AdminController@index')->where('any', '.*');
});

