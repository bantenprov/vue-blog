<?php
Route::get('/blog', function () {

    return Bantenprov\VueBlog\Blog::all();

})->name('blog');

Route::group(['middleware' => ['web','auth']], function () {
    Route::resource('blog', 'BlogController');
});

Route::group(['middleware' => ['web','auth','api'],'prefix' => 'api'], function () {
	Route::get('blog','BlogController@getData')->name('api.blog');
});
