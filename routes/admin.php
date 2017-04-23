<?php

$middlewares = [
    'auth',
    'role:admin'
];

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => $middlewares], function () {

    Route::get('', 'Admin\AdminController@index')->name('index');
    Route::get('generate-error', 'Admin\AdminController@generateError')->name('generate-error');

    Route::get('users', 'Admin\UserController@index')->name('users.index');
    Route::get('user/{user}', 'Admin\UserController@edit')->name('users.edit');
    Route::post('user/{user}', 'Admin\UserController@update')->name('users.update');

    Route::get('ghost/{user}', 'Admin\UserController@ghost')->name('users.ghost')->middleware(['role:super-admin']);
    Route::get('download-dump/{user}', 'Admin\UserController@downloadLua')->name('users.download-dump');

    Route::get('crafting/motifs', 'Admin\CraftingController@itemStyles')->name('crafting.itemstyles');
    Route::get('crafting/motifs/{itemStyle}', 'Admin\CraftingController@itemStyle')->name('crafting.item-style.edit');
    Route::post('crafting/motifs/upload-images/{itemStyle}', 'Admin\CraftingController@uploadImages')->name('crafting.item-style.upload-images');
    Route::post('crafting/motifs', 'Admin\CraftingController@updateStyles')->name('crafting.updateStyles');
    Route::post('crafting/motifs/{itemStyle}', 'Admin\CraftingController@updateItemStyle')->name('crafting.item-style.update');


    Route::get('generate-slugs', 'Admin\SlugController@generateSlugs')->name('generate-slugs');

    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

    Route::get('errors', '\HeppyKarlsson\DBLogger\Controller\ErrorController@index')->name('errors.index');
    Route::get('errors/truncate', '\HeppyKarlsson\DBLogger\Controller\ErrorController@truncate')->name('errors.truncate')->middleware(['role:super-admin']);
    Route::get('error/{log}', '\HeppyKarlsson\DBLogger\Controller\ErrorController@show')->name('error.show');


    Route::get('dungeon/create', 'DungeonController@create')->name('dungeon.create');
    Route::post('dungeon', 'DungeonController@store')->name('dungeon.store');
    Route::put('dungeon/{dungeon}', 'DungeonController@update')->name('dungeon.update');
    Route::get('dungeon/{dungeon}/edit', 'DungeonController@edit')->name('dungeon.edit');


    Route::get('boss/create', 'Admin\BossController@create')->name('boss.create');
    Route::get('boss/{boss}/edit', 'Admin\BossController@edit')->name('boss.edit');
    Route::get('boss/{boss}/delete', 'Admin\BossController@delete')->name('boss.delete');
    Route::put('boss/{boss}', 'Admin\BossController@update')->name('boss.update');
    Route::post('boss', 'Admin\BossController@store')->name('boss.store');

    Route::get('crafting/crafting-items/populate', 'Admin\CraftingController@populateCraftingItems')->name('crafting.crafting-items.populate');

    Route::get('crafting-table/{smithingType}', 'Admin\CraftingController@craftingTable')->name('crafting-table.edit');
    Route::post('crafting-table/{smithingType}', 'Admin\CraftingController@updateCraftingTable')->name('crafting-table.update');


    include('web/admin/roles.php');


});
