<?php

# spa 后台，整站 spa 去掉外层 admin
Route::name('admin')->group(function() {
    Route::get('{any}', 'Admin\AdminController@index')->where('any', '.*');
});