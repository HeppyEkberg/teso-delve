<?php

Route::get('/roles', 'Admin\RoleController@index')->name('role.index');
Route::post('/role/{role?}', 'Admin\RoleController@save')->name('role.save');
Route::get('/role/{role}', 'Admin\RoleController@edit')->name('role.edit');

Route::post('/permission', 'Admin\PermissionController@store')->name('permission.store');
