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

// Pages Routes
Route::get('/', 'PageController@home');
Route::get('/home', 'PageController@home');
Route::get('/about', 'PageController@about');
Route::get('/posts/search', 'PageController@search');

// Serach the post
Route::post('/posts/search', 'PageController@findPost'); 

Auth::routes();

// Post Routes
Route::resource('/posts', 'PostController');

// Like Routes
Route::resource('/likes', 'LikeController');

// Comment Routes
Route::resource('/comments', 'CommentController');
Route::delete('/commentsDelete', 'CommentController@deleteComment');
Route::post('/comments/{id}', 'CommentController@update');

// MyProfile Routes
Route::get('/dashboard', 'DashboardController@index');
Route::get('/myProfile', 'DashboardController@myProfile');
Route::post('/myProfile', 'DashboardController@updateProfilePic');
Route::post('/myProfileData', 'DashboardController@myProfileData');