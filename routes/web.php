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

Route::get('/', 'Auth\UserController@login');


// Demo routes
Route::get('/datatables', 'PagesController@datatables');
Route::get('/ktdatatables', 'PagesController@ktDatatables');
Route::get('/select2', 'PagesController@select2');
Route::get('/jquerymask', 'PagesController@jQueryMask');
Route::get('/icons/custom-icons', 'PagesController@customIcons');
Route::get('/icons/flaticon', 'PagesController@flaticon');
Route::get('/icons/fontawesome', 'PagesController@fontawesome');
Route::get('/icons/lineawesome', 'PagesController@lineawesome');
Route::get('/icons/socicons', 'PagesController@socicons');
Route::get('/icons/svg', 'PagesController@svg');

// Quick search dummy route to display html elements in search dropdown (header search)
Route::get('/quick-search', 'PagesController@quickSearch')->name('quick-search');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => '/', "namespace" =>'Auth',"as" => "user."], function () {
    Route::get('/registration', 'UserController@register')->name('registration.form');
    Route::post('/registration', 'UserController@processRegistration')->name('registration.save');

    Route::group(["prefix" => '/payment', "as" => "payPal.Payment."], function () {
        Route::get('paypal/cancel', 'UserController@cancelPaypalPayment')->name('cancel');
        Route::get('paypal/success', 'UserController@successPaypalPayment')->name('success');
    });
});


Route::group(['prefix' => '/admin', "middleware" =>'sentinelAuth'], function () {
    Route::group(["as" => "admin."], function () {
        Route::group(['prefix' => '/', "namespace" =>'Auth',"as" => "user."], function () {
            Route::get('/', 'UserController@login')->name('login.form');
            Route::get('/login', 'UserController@login')->name('login.form');
            Route::post('/login', 'UserController@processLogin')->name('login.save');
            Route::post('/logout', 'UserController@logout')->name('logout');
    
            /**
             * Member's Route
             */
            Route::any('users', 'UserController@userlist')->name('list');
            Route::get('/user/edit/{userId}', 'UserController@userEdit')->name('edit.form');
            Route::put('/user/edit/{userId}', 'UserController@userUpdateUser')->name('edit.action');
            Route::delete('/user/delete/{userId}', ['uses' => 'UserController@userDestroy'])->name('destroy');
            Route::get('/user/{userId}/status', ['uses' => 'UserController@userChangeStatus'])->name('changeStatus');
        });
        
        Route::get('/dashboard', 'PagesController@index')->name('dashboard');
        Route::get('/dashboard1', 'PagesController@index1')->name('dashboard1');

        Route::get('/udpcardprinting/{userId}', 'Auth\UserController@printIdCards')->name('member.Card.Print');

        Route::get('/notification', 'NotificationController@openMailform')->name('mail.notification.form');
        Route::post('/notification', 'NotificationController@sendMail')->name('mail.notification.send');
    });
    /**
     * Role Route
     */
    Route::group(["prefix" => '/role', "as" => "role."], function () {
        Route::any('/', 'RoleController@index')->name('index');
        Route::get('/add', 'RoleController@create')->name('create.form');
        Route::post('/add', 'RoleController@store')->name('create.action');
        Route::get('/slug', 'RoleController@slugCreate')->name('slug.create');
        Route::get('/edit/{role}', 'RoleController@edit')->name('edit.form');
        Route::put('/edit/{role}', 'RoleController@update')->name('edit.action');
        Route::delete('/delete/{role}', 'RoleController@destroy')->name('destroy');
    });
    /**
     * User Route
     */
    Route::group(['prefix' => '/system_user', "namespace" =>'Auth',"as" => "systemuser."], function () {
        Route::any('/', 'UserController@systemUserList')->name('index');
        Route::get('/add', 'UserController@systemUserRegister')->name('create.form');
        Route::post('/add', ['uses' => 'UserController@systemUserProcessRegistration'])->name('create.action');
        Route::get('/edit/{userId}', 'UserController@systemUserEdit')->name('edit.form');
        Route::put('/edit/{userId}', 'UserController@systemUserUpdate')->name('edit.action');
        Route::delete('/delete/{userId}', ['uses' => 'UserController@systemUserDestroy'])->name('destroy');
        Route::get('/{userId}/status', ['uses' => 'UserController@systemUserChangeStatus'])->name('changeStatus');
    });
    /**
     * Chapter Route
     */
    Route::group(['prefix' => '/chapter', "as" => "chapter."], function () {
        Route::any('/', 'ChapterController@index')->name('index');
        Route::get('/add', 'ChapterController@create')->name('create.form');
        Route::post('/add', 'ChapterController@store')->name('create.action');
        Route::get('/edit/{chapterId}', 'ChapterController@edit')->name('edit.form');
        Route::put('/edit/{chapterId}', 'ChapterController@update')->name('edit.action');
        Route::delete('/delete/{chapterId}', ['uses' => 'ChapterController@destroy'])->name('destroy');
    });
    /**
     * Voter Route
     */
    Route::group(['prefix' => '/voter', "as" => "voter."], function () {
        Route::any('/', 'VoterController@index')->name('index');
        Route::get('/add', 'VoterController@create')->name('create.form');
        Route::post('/add', 'VoterController@store')->name('create.action');
        Route::get('/edit/{voterId}', 'VoterController@edit')->name('edit.form');
        Route::put('/edit/{voterId}', 'VoterController@update')->name('edit.action');
        Route::delete('/delete/{voterId}', ['uses' => 'VoterController@destroy'])->name('destroy');

        Route::post('bulkvoters', 'VoterController@bulkUploadVoters')->name('bulk.voter');
        Route::post('bulkcities', 'VoterController@bulkuploadCity')->name('bulk.city');
    });
});