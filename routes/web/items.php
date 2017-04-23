<?php

Route::get('/item/{item_id}', 'ItemController@showItemById')->where('item_id', '[\d+]+');
Route::get('/item/users/{id}', 'UserController@getProfile')->where('id', '[\d+]+');
