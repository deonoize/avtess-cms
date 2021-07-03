<?php
// Site routes
Route::match(
    [
        'get',
        'post',
    ],
    '/ajax',
    'Deonoize\AvtessCMS\Controllers\SiteController@ajaxIndex'
)->name('site.ajax.index');
Route::match(
    [
        'get',
        'post',
    ],
    '/ajax/{page_name}',
    'Deonoize\AvtessCMS\Controllers\SiteController@ajax'
)->name('site.ajax.page')->where('page_name', '.*');
Route::match(
    [
        'get',
        'post',
    ],
    '/',
    'Deonoize\AvtessCMS\Controllers\SiteController@pageIndex'
)->name('site.index');
Route::match(
    [
        'get',
        'post',
    ],
    '/{page_name}',
    'Deonoize\AvtessCMS\Controllers\SiteController@page'
)->name('site.page')->where('page_name', '(.|/)*');
