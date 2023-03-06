<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('website.index');
})->name('index');

Route::resource('/posts','PostController');
Route::get('showFromNotification/{post}/{notification}', 'PostController@showFromNotification')
->name('posts.showFromNotification');
Route::get('/mespublications', 'PostController@showmyposts')->name('myposts');

Route::post('/comments/{post}','CommentController@store')->name('comments.store');
Route::post('/commentReply/{comment}', 'CommentController@storeCommentReply')->name('comments.storeReply');

Auth::routes([
   // "register" => false, //Pour désactiver le Register
    "reset"    => false //Pour désactiver le reset du mot de passe
]
);

//Route::get('/home', 'HomeController@index')->name('home');
