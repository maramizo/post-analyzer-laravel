<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

//Homepage.
Route::get('/home', 'HomeController@index')->name('home.index');


//Profile routes: create, show.
Route::get('/profile/create', 'ProfilesController@create')->name('profile.create');
Route::get('/profile/{profile}', 'ProfilesController@index')->name('profile.show');
Route::post('profile/store', 'ProfilesController@store')->name('profile.store');

//User display route.
Route::get('/user/{user}', 'UsersController@index')->name('user.show');

//Message pagination route.
Route::get('/profile/{profile}/messages/{type}/show', 'MessagesController@show');

//Personality route.
Route::get('/personality/{profile}', 'PersonalitiesController@show');

//Wiki middleman route.
Route::get('/wiki/{name}', 'WikiController@search')->name('wiki.search');
Route::get('/wiki/detailed/{name}', 'WikiController@show')->name('wiki.show');
