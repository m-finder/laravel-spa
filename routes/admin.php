<?php

Route::get('/admin/{any}', 'Admin\AdminController@index')->where('any', '.*');