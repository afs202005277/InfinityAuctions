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
Route::get('/faq', function () { return view('pages.faq'); });

Route::get('/about-us', function () { return view('pages.about'); });
Route::get('/contact-us', function () { return view('pages.contacts'); });
Route::get('/services', function () { return view('pages.services'); });


Route::get('auctions/{auction_id}', 'AuctionController@show');

// API
Route::get('api/auctions/getAllBids/{auction_id}', 'AuctionController@getAllBids');
Route::post('api/auctions', 'BidController@store');
Route::get('api/search', 'SearchController@search');
Route::delete('api/image/{id}', 'ImageController@delete');

// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

//User
Route::get('user/{id}', 'UserController@show');
Route::post('user/{id}', 'UserController@update')->name('editUser');

//Users
Route::get('users', 'UsersController@index');
Route::get('users/{id}', 'UsersController@show');
Route::get('users/report/{id}', 'UsersController@showreport');
Route::post('users/report', 'UsersController@report')->name('report');

//Admin Panel
Route::get('manage', 'ManageController@show');

// Auctions
Route::post('sell', 'AuctionController@sell');
Route::post('auctions/cancel/{id}', 'AuctionController@cancel');
Route::get('auctions/edit/{id}', 'AuctionController@edit');
Route::post('auctions/edit/{id}', 'AuctionController@update')->name('editAuction');
Route::get('sell', 'AuctionController@showSellForm')->name('sell');
Route::post('sell', 'AuctionController@sell');
Route::get('search', 'SearchPageController@show');
