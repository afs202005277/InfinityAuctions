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
use App\Http\Controllers\MainPageController;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

Route::get('/', MainPageController::class);
Route::get('/faq', function () {
    return view('pages.faq');
});

Route::get('/about-us', function () {
    return view('pages.about');
});
Route::get('/contact-us', function () {
    return view('pages.contacts');
});
Route::get('/services', function () {
    return view('pages.services');
});


Route::get('auctions/{auction_id}', 'AuctionController@show');

// API
Route::get('api/auctions/getAllBids/{auction_id}', 'AuctionController@getAllBids');
Route::post('api/auctions', 'BidController@store');
Route::get('api/search', 'SearchController@search');
Route::delete('api/image/{id}', 'ImageController@delete');
Route::delete('api/users/delete/{id}', 'UserController@destroy');
Route::post('api/users/addReview', 'UserController@addReview');

// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

//User
Route::post('api/user/follow_auction', 'UserController@follow_auction');
Route::post('api/user/unfollow_auction', 'UserController@unfollow_auction');
Route::get('user/{id}', 'UserController@show');
Route::post('user/{id}', 'UserController@update')->name('editUser');
Route::post('api/user/follow_term', 'WishlistController@follow_term');
Route::post('api/user/unfollow_term', 'WishlistController@unfollow_term');
Route::post('/api/user/follows_term', 'WishlistController@follows');

//Users
Route::get('users', 'UsersController@index');
Route::get('users/{id}', 'UsersController@show');
Route::get('users/report/{id}', 'ReportController@showUserReport');
Route::post('users/report', 'ReportController@report')->name('reportUser');

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
Route::get('auctions/report/{id}', 'ReportController@showAuctionReport');
Route::get('auctions/checkout/{auction_id}', 'AuctionController@showAuctionCheckout');
Route::post('auctions/report', 'ReportController@report')->name('reportAuction');


//Notifications
Route::delete('api/notifications/delete/{id}', 'NotificationController@destroy');

//Password
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);
    $status = Password::sendResetLink(
        $request->only('email')
    );
    return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:6|confirmed',
    ]);
    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));
            $user->save();
            event(new PasswordReset($user));
        }
    );
    return $status === Password::PASSWORD_RESET
        ? redirect()->route('login')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');

//Payments
Route::get('balance', 'PaypalController@show')->name('payments');

Route::get('deposit', 'PayPalController@payment')->name('deposit');
Route::get('deposit/cancel', 'PayPalController@cancel')->name('deposit.cancel');
Route::get('deposit/success', 'PayPalController@success')->name('deposit.success');

Route::get('withdraw', 'PayPalController@withdraw')->name('withdraw');
Route::get('withdraw/cancel', 'PayPalController@withdrawCancel')->name('withdraw.cancel');
Route::get('withdraw/success', 'PayPalController@withdrawSuccess')->name('withdraw.success');