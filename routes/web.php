<?php

Route::group(['middleware' => 'web'], function () {
    Route::get('/', 'BasicController@homePage')->name('home');
    Route::get('/classify', 'GameController@classifyPage')->name('classify');
    Route::get('/game', 'GameController@gamePage')->name('game');
    Route::get('/game/classify/{classify?}', 'GameController@gameClassifyPage')->name('game.classify');
    Route::get('/showbiz', 'ShowBizController@showBizPage')->name('showbiz');
});

Route::group(['middleware' => 'user'], function () {
    Route::get('/broadcast/view/{id?}', 'BroadcastController@broadcastViewPage')->name('broadcast.view');
    Route::get('/broadcast', 'BroadcastController@broadcastLivePage')->name('broadcast');
});

Route::group(['prefix' => 'auth', 'middleware' => 'web', 'namespace' => 'Auth', 'as' => 'auth.'], function () {
    Route::post('register', 'AuthController@postRegister')->name('register');
    Route::post('login', 'AuthController@postLogin')->name('login');
    Route::get('logout', 'AuthController@getLogout')->name('logout');
    Route::post('resetpassword', 'AuthController@resetPassword')->name('reset.password');

    Route::post('/sendcode', ['as' => 'sendcode', 'uses' => 'AuthController@sendCode']);
    Route::get('/social/redirect/{provider?}', ['as' => 'social.redirect', 'uses' => 'SocialController@getSocialRedirect']);
    Route::get('/social/handle/{provider?}', ['as' => 'social.handle', 'uses' => 'SocialController@getSocialHandle']);
});

Route::group(['prefix' => 'api', 'middleware' => 'web', 'namespace' => 'Api', 'as' => 'api.'], function () {
    Route::get('/countrylist', 'ApiController@countryList')->name('countrylist');
    Route::get('/classifylist', 'ApiController@classifyList')->name('classifylist');
    Route::get('/gamelist', 'ApiController@gameList')->name('gamelist');
    Route::get('/recommendlist', 'ApiController@recommendList')->name('recommendlist');
    Route::get('/livelist', 'ApiController@liveList')->name('livelist');
    Route::get('/advertise', 'ApiController@advertise')->name('advertise');
    Route::get('/view/token', 'ApiController@viewToken')->name('view.token');
    Route::get('/viewuserlist', 'ApiController@mostViewUserList')->name('viewuserlist');
    Route::get('/beanuserlist', 'ApiController@mostBeanUserList')->name('beanuserlist');
});

Route::group(['prefix' => 'setting', 'middleware' => 'user', 'as' => 'setting.'], function () {
    Route::get('/index', 'SettingController@indexPage')->name('index');
    Route::get('/profile', 'SettingController@profilePage')->name('profile');
    Route::post('/profile/save', 'SettingController@saveProfile')->name('profile.save');
    Route::post('/upload/avatar', 'SettingController@uploadAvatar')->name('upload.avatar');
    Route::get('/recharge', 'SettingController@rechargePage')->name('recharge');
    Route::get('/broadcast', 'SettingController@broadcastPage')->name('broadcast');
    Route::post('/broadcast/upload/avatar', 'SettingController@uploadBroadcastAvatar')->name('broadcast.upload.avatar');
    Route::post('/broadcast/save', 'SettingController@saveBroadcast')->name('broadcast.save');
    Route::get('/recharge/history', 'SettingController@rechargeHistoryPage')->name('recharge.history');
    Route::get('/recharge/paypal', 'SettingController@paypalPage')->name('recharge.paypal');
    Route::post('/recharge/charge', 'SettingController@charge')->name('recharge.charge');

    Route::post('/recharge/checkout/paypal/{transaction}', 'SettingController@checkOutPaypal')->name('recharge.checkout.paypal');
    Route::get('/recharge/checkout/paypal/complete/{transaction}', 'SettingController@completePaypal')->name('recharge.checkout.paypal.complete');
    Route::get('/recharge/checkout/paypal/cancel/{transaction}', 'SettingController@cancelPaypal')->name('recharge.checkout.paypal.cancel');
    Route::post('/recharge/webhook/paypal/{transaction?}/{env?}', 'SettingController@webhookPaypal')->name('recharge.webhook.paypal');
});


Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'admin', 'as' => 'admin.'], function () {

    Route::get('/', 'JoshController@showHome')->name('dashboard');

    # User Management
    Route::group(['prefix' => 'users'], function () {
        Route::get('data', 'UsersController@data')->name('users.data');
        Route::get('{user}/delete', 'UsersController@destroy')->name('users.delete');
        Route::get('{user}/confirm-delete', 'UsersController@getModalDelete')->name('users.confirm-delete');
        Route::get('{user}/disable', 'UsersController@disable')->name('users.disable');
        Route::get('{user}/confirm-disable', 'UsersController@getModalDisable')->name('users.confirm-disable');
        Route::get('{user}/enable', 'UsersController@enable')->name('users.enable');
        Route::get('{user}/restore', 'UsersController@getRestore')->name('restore.user');
        Route::get('{user}/show', 'UsersController@show')->name('users.show');

    });
    Route::resource('users', 'UsersController');

    Route::get('deleted_users', ['before' => 'Sentinel', 'uses' => 'UsersController@getDeletedUsers'])->name('deleted_users');

    # Category Management
    Route::group(['prefix' => 'classify'], function () {
        Route::get('{classify}/delete', 'ClassifyController@destroy')->name('classify.delete');
        Route::get('{classify}/confirm-delete', 'ClassifyController@getModalDelete')->name('classify.confirm-delete');
    });

    Route::resource('classify', 'ClassifyController');

    # SubCategory Management
    Route::group(['prefix' => 'country'], function () {
        Route::get('{country}/delete', 'CountryController@destroy')->name('country.delete');
        Route::get('{country}/confirm-delete', 'CountryController@getModalDelete')->name('country.confirm-delete');
    });

    Route::resource('country', 'CountryController');

    # Broadcast Management
    Route::group(['prefix' => 'broadcast'], function () {
        Route::get('{broadcast}/delete', 'BroadcastController@destroy')->name('broadcast.delete');
        Route::get('{broadcast}/confirm-delete', 'BroadcastController@getModalDelete')->name('broadcast.confirm-delete');
        Route::get('{broadcast}/presents', 'BroadcastController@presents')->name('broadcast.presents');
        Route::get('{broadcast}/enable', 'BroadcastController@enable')->name('broadcast.enable');
        Route::get('{broadcast}/show', 'BroadcastController@show')->name('broadcast.show');
        Route::get('{broadcast}/connect', 'BroadcastController@connect')->name('broadcast.connect');

        Route::get('gaming', 'BroadcastController@gaming')->name('broadcast.gaming');
        Route::get('showbiz', 'BroadcastController@showbiz')->name('broadcast.showbiz');
    });

    Route::resource('broadcast', 'BroadcastController');

    # Transaction Management
    Route::group(['prefix' => 'transaction'], function () {
        Route::get('{transaction}/delete', 'TransactionController@destroy')->name('transaction.delete');
        Route::get('{transaction}/confirm-delete', 'TransactionController@getModalDelete')->name('transaction.confirm-delete');
        Route::get('{transaction}/enable', 'TransactionController@enable')->name('transaction.enable');
        Route::get('{transaction}/show', 'TransactionController@show')->name('transaction.show');
    });

    Route::resource('transaction', 'TransactionController');

});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('404', function () {
        return view('admin/404');
    });
    Route::get('500', function () {
        return view('admin/500');
    });
    Route::get('{id}/lockscreen', 'UsersController@lockscreen')->name('lockscreen');
    Route::post('{id}/lockscreen', 'UsersController@postLockscreen')->name('lockscreen');
    # All basic routes defined here
    Route::get('login', 'AuthController@getSignin')->name('login');
    Route::get('signin', 'AuthController@getSignin')->name('signin');
    Route::post('signin', 'AuthController@postSignin')->name('postSignin');
    # Logout
    Route::get('logout', 'AuthController@getLogout')->name('logout');
});


