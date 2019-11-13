<?php

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});
Route::namespace('Cms')->name('cms.')->group(function () {
    require_once "cms.php";
});



