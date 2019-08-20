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

Route::get('/', 'MicropostsController@index');

// ユーザ登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');   //signupにgetメソッドでアクセスした場合、Auth\RegisterControllerクラスの@showRegistrationForm関数が呼ばれる
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// ログイン認証
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout.get');

// ユーザ機能
Route::group(['middleware' => ['auth']], function () {
    Route::resource('users', 'UsersController', ['only' => ['index', 'show']]);  //”URLのrouteを作成しただけ”。このコードで飛ばしてはない。resourceを使用しているので、飛ばす先をUserControlerの@index,@showに限定している。
    
    Route::group(['prefix' => 'users/{id}'], function () {    //prefixはルートを表す　users/idというurlでアクセスすると・・・
        Route::post('follow', 'UserFollowController@store')->name('user.follow');
        Route::delete('unfollow', 'UserFollowController@destroy')->name('user.unfollow');
        Route::get('followings', 'UsersController@followings')->name('users.followings');
        Route::get('followers', 'UsersController@followers')->name('users.followers');
    });    
    
    
    // 追加
    Route::group(['prefix' => 'microposts/{id}'], function () {    //prefixはルートを表す　microposts/idというurlでアクセスすると、post、deleteが機能する。
        Route::post('favorite', 'FavoritesController@store')->name('favorites.favorite');    //お気に入りボタンを押すと機能する　FavoritesController@storeに飛ばす　microposts/id=post/id？　　　→　FavoritesControllerを作成する必要がある
        Route::delete('unfavorite', 'FavoritesController@destroy')->name('favorites.unfavorite');
        Route::get('get_favorite', 'FavoritesController@get_favorites')->name('favorites.get_favorites');
    });

    
    Route::resource('microposts', 'MicropostsController', ['only' => ['store', 'destroy']]); //MicropostsControllerのstoreかdestroymethodに飛ぶという意味
    
    
});

