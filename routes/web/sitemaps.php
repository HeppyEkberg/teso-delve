<?php

Route::get('/sitemap.xml', 'SitemapController@sitemap')->name('sitemap.show');
Route::get('/items.xml', 'SitemapController@items')->name('items.show');
