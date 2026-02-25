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

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('public.home');
});

// ===== PUBLIC =====
Route::get('/utama', 'PublicController@home')->name('public.home');
Route::get('/utama/events', 'PublicController@events')->name('public.events');
Route::get('/utama/event/{id}', 'PublicController@eventShow')->name('public.event.show');
Route::get('/utama/event-modal/{id}', 'PublicController@eventModal')->name('public.event.modal');
Route::get('/utama/embed', 'PublicController@embed')->name('public.embed')->middleware('allow.iframe');

// Login & logout function
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/first-time-login', 'Auth\LoginController@showForm')->name('firsttimelogin.form');
Route::post('/first-time-login', 'Auth\LoginController@sendLink')->name('firsttimelogin.send');

Route::get('/manual-pengguna', function () {
    return redirect(url('public/storage/Manual Pengguna Sistem Takwim.pdf'));
})->name('manual-pengguna');

// routes/web.php
Route::get('/pengesahan-akaun', 'UserController@showPengesahanAkaunForm')->name('pengesahanakaun.form');
Route::post('/first-time', 'UserController@handleFirstTime')->name('firsttime.handle');
Route::get('register', 'UserController@showPublicRegisterForm')->name('register');
Route::post('register', 'UserController@storePublicRegister')->name('register.store');
Route::get('/verify-email/{token}', 'UserController@verifyEmail')->name('verify.email');

// Password Reset Routes
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

Route::middleware('auth')->group(function () {

    //Campus
    Route::get('campus', 'CampusController@index')->name('campus');
    Route::get('campus/view/{id}', 'CampusController@show')->name('campus.show');
    Route::get('/campus/search', 'CampusController@search')->name('campus.search');

    //Event
    Route::get('event', 'EventController@index')->name('event');
    Route::get('event/view/{id}', 'EventController@show')->name('event.show');
    Route::get('/event/search', 'EventController@search')->name('event.search');

    //Ptj
    Route::get('ptj', 'PtjController@index')->name('ptj');
    Route::get('ptj/view/{id}', 'PtjController@show')->name('ptj.show');
    Route::get('/ptj/search', 'PtjController@search')->name('ptj.search');

    //Position
    Route::get('position', 'PositionController@index')->name('position');
    Route::get('position/view/{id}', 'PositionController@show')->name('position.show');
    Route::get('/position/search', 'PositionController@search')->name('position.search');

    Route::get('/home', 'DashboardController@index')->name('home');

    // endpoint JSON untuk FullCalendar tarik data event
    Route::get('/dashboard/events', 'DashboardController@events')->name('dashboard.events');

    // User Profile
    Route::get('profile/{id}', 'UserProfileController@show')->name('profile.show');
    Route::get('profile/{id}/edit', 'UserProfileController@edit')->name('profile.edit');
    Route::put('profile/{id}', 'UserProfileController@update')->name('profile.update');
    Route::get('profile/{id}/change-password', 'UserProfileController@changePasswordForm')->name('profile.change-password');
    Route::post('profile/{id}/change-password', 'UserProfileController@changePassword')->name('profile.update-password');

    // Superadmin - Activity Log
    Route::get('activity-log', 'ActivityLogController@index')->name('activity-log');
    Route::get('/debug-logs', 'ActivityLogController@showDebugLogs')->name('logs.debug');

    // User Management
    Route::get('user', 'UserController@index')->name('user');
    Route::get('user/create', 'UserController@create')->name('user.create');
    Route::post('user/store', 'UserController@store')->name('user.store');
    Route::get('user/{id}/edit', 'UserController@edit')->name('user.edit');
    Route::post('user/{id}', 'UserController@update')->name('user.update');
    Route::get('user/view/{id}', 'UserController@show')->name('user.show');
    Route::get('/user/search', 'UserController@search')->name('user.search');
    Route::delete('user/{id}', 'UserController@destroy')->name('user.destroy');
    Route::get('/user/trash', 'UserController@trashList')->name('user.trash');
    Route::get('/user/{id}/restore', 'UserController@restore')->name('user.restore');
    Route::delete('/user/{id}/force-delete', 'UserController@forceDelete')->name('user.forceDelete');
    Route::get('user/import', 'UserController@importForm')->name('user.importForm');
    Route::post('user/import', 'UserController@import')->name('user.import');

    // User Role Management
    Route::get('user-role', 'UserRoleController@index')->name('user-role');
    Route::get('user-role/create', 'UserRoleController@create')->name('user-role.create');
    Route::post('user-role/store', 'UserRoleController@store')->name('user-role.store');
    Route::get('user-role/{id}/edit', 'UserRoleController@edit')->name('user-role.edit');
    Route::post('user-role/{id}', 'UserRoleController@update')->name('user-role.update');
    Route::get('user-role/view/{id}', 'UserRoleController@show')->name('user-role.show');
    Route::get('/user-role/search', 'UserRoleController@search')->name('user-role.search');
    Route::delete('user-role/{id}', 'UserRoleController@destroy')->name('user-role.destroy');
    Route::get('/user-role/trash', 'UserRoleController@trashList')->name('user-role.trash');
    Route::get('/user-role/{id}/restore', 'UserRoleController@restore')->name('user-role.restore');
    Route::delete('/user-role/{id}/force-delete', 'UserRoleController@forceDelete')->name('user-role.forceDelete');

    //Campus
    Route::get('campus/create', 'CampusController@create')->name('campus.create');
    Route::post('campus/store', 'CampusController@store')->name('campus.store');
    Route::get('campus/{id}/edit', 'CampusController@edit')->name('campus.edit');
    Route::post('campus/{id}', 'CampusController@update')->name('campus.update');
    Route::delete('campus/{id}', 'CampusController@destroy')->name('campus.destroy');
    Route::get('/campus/trash', 'CampusController@trashList')->name('campus.trash');
    Route::get('/campus/{id}/restore', 'CampusController@restore')->name('campus.restore');
    Route::delete('/campus/{id}/force-delete', 'CampusController@forceDelete')->name('campus.forceDelete');

    //Events
    Route::get('event/create', 'EventController@create')->name('event.create');
    Route::post('event/store', 'EventController@store')->name('event.store');
    Route::get('event/{id}/edit', 'EventController@edit')->name('event.edit');
    Route::post('event/{id}', 'EventController@update')->name('event.update');
    Route::delete('event/{id}', 'EventController@destroy')->name('event.destroy');
    Route::get('/event/trash', 'EventController@trashList')->name('event.trash');
    Route::get('/event/{id}/restore', 'EventController@restore')->name('event.restore');
    Route::delete('/event/{id}/force-delete', 'EventController@forceDelete')->name('event.forceDelete');
    Route::delete('/event/attachment/{id}', 'EventController@deleteAttachment')
        ->name('event.attachment.delete');

    //Ptj
    Route::get('ptj/create', 'PtjController@create')->name('ptj.create');
    Route::post('ptj/store', 'PtjController@store')->name('ptj.store');
    Route::get('ptj/{id}/edit', 'PtjController@edit')->name('ptj.edit');
    Route::post('ptj/{id}', 'PtjController@update')->name('ptj.update');
    Route::delete('ptj/{id}', 'PtjController@destroy')->name('ptj.destroy');
    Route::get('/ptj/trash', 'PtjController@trashList')->name('ptj.trash');
    Route::get('/ptj/{id}/restore', 'PtjController@restore')->name('ptj.restore');
    Route::delete('/ptj/{id}/force-delete', 'PtjController@forceDelete')->name('ptj.forceDelete');

    //Position
    Route::get('position/create', 'PositionController@create')->name('position.create');
    Route::post('position/store', 'PositionController@store')->name('position.store');
    Route::get('position/{id}/edit', 'PositionController@edit')->name('position.edit');
    Route::post('position/{id}', 'PositionController@update')->name('position.update');
    Route::delete('position/{id}', 'PositionController@destroy')->name('position.destroy');
    Route::get('/position/trash', 'PositionController@trashList')->name('position.trash');
    Route::get('/position/{id}/restore', 'PositionController@restore')->name('position.restore');
    Route::delete('/position/{id}/force-delete', 'PositionController@forceDelete')->name('position.forceDelete');
});
