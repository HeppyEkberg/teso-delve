<?php


Route::get('/character/{character}/delete', 'CharacterController@delete')->name('characters.delete');
Route::get('/character/{character}/restore', 'CharacterController@restore')->name('characters.restore');
Route::get('/character/{character}', 'CharacterController@show')->name('characters.show');
Route::get('/character/{character}/crafting/{craftingTypeEnum}', 'CharacterController@craftingResearch')->name('character.crafting');
Route::get('/character/{character}/motifs', 'CharacterController@itemStyles')->name('character.itemstyles');
Route::get('/characters/deleted', 'CharacterController@indexDeleted')->name('characters.index.deleted')->middleware('auth');
Route::get('/characters', 'CharacterController@index')->name('characters.index')->middleware('auth');

Route::get('/character/{character}/skills/{skillLine?}', 'CharacterController@skills')->name('character.skills')->middleware('auth');


Route::get('/character/{character}/inventory', 'CharacterController@inventory')->name('character.inventory')->middleware('auth');