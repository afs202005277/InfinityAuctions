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
// Home
Route::get('/', MainPageController::class);
Route::get('/faqs', function () { return view('pages.faq'); });
Route::get('/about', function () { return view('pages.about'); });
Route::get('/contacts', function () { return view('pages.contacts'); });
Route::get('/services', function () { return view('pages.services'); });

Route::get('search/{query}', 'AuctionController@showSearchResults');

// Cards
Route::get('cards', 'CardController@list');
Route::get('auctions/{auction_id}', 'AuctionController@show');

// API
Route::get('api/auctions/getAllBids/{auction_id}', 'AuctionController@getAllBids');
Route::post('api/auctions', 'BidController@store');
Route::delete('api/cards/{card_id}', 'CardController@delete');
Route::put('api/cards/{card_id}/', 'ItemController@create');
Route::post('api/item/{id}', 'ItemController@update');
Route::delete('api/item/{id}', 'ItemController@delete');
Route::get('api/search', 'SearchController@search');

// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

//User
Route::get('user/{id}', 'UserController@show');
Route::post('user/{id}', 'UserController@edit');

//Users
Route::get('users', 'UsersController@index');
Route::get('users/{id}', 'UsersController@show');

//Admin Panel
Route::get('manage/', 'ManageController@show');

// Auctions
Route::post('sell', 'AuctionController@sell');
Route::post('auctions/cancel/{id}', 'AuctionController@cancel');
Route::get('auctions/edit/{id}', 'AuctionController@edit');
Route::get('sell', 'AuctionController@showSellForm')->name('sell');
Route::post('sell', 'AuctionController@sell');
