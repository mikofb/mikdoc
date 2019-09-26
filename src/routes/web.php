<?php

Route::get('/', 'DocumentsController@index')->name(config('mikdoc.routes.prefix').'.index');
Route::get('/{slug}', 'DocumentsController@show')->name(config('mikdoc.routes.prefix').'.show');
Route::get('/{slug}/operations', 'DocumentsController@operations')->name(config('mikdoc.routes.prefix').'.operations');
Route::get('/search/q', 'DocumentsController@search')->name(config('mikdoc.routes.prefix').'.search');
Route::get('/search/q/{slug}', 'DocumentsController@search_query')->name(config('mikdoc.routes.prefix').'.search_query');
Route::get('/{slug}/load', 'DocumentsController@load')->name(config('mikdoc.routes.prefix').'.load');
Route::post('/', 'DocumentsController@store')->name(config('mikdoc.routes.prefix').'.store');
Route::post('/upload', 'DocumentsController@upload')->name(config('mikdoc.routes.prefix').'.upload');
Route::put('/{slug}', 'DocumentsController@update')->name(config('mikdoc.routes.prefix').'.update');
Route::delete('/{id}', 'DocumentsController@destroy')->name(config('mikdoc.routes.prefix').'.destroy');
