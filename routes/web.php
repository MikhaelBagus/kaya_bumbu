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


// login
Route::group(['prefix' => '/login'], function () {
	Route::get('', 'Auth\LoginController@showLoginForm')
		->name('login.form');

	Route::post('/process', 'Auth\LoginController@login')
		->name('login.process')->middleware( 'prevent.back.history');
});

// logout
Route::group(['prefix' => '/logout'], function () {
	Route::get('', 'Auth\LoginController@logout')
		->name('logout')->middleware('prevent.back.history');
});

// forgot password
Route::group(['prefix' => 'password'], function () {
    Route::get('forgot', 'Auth\ForgotPasswordController@index')
    	->name('auth.forgot.password.form');

    Route::post('send-reset-link', 'Auth\ForgotPasswordController@sendResetLinkResponse')
    	->name('auth.forgot.password.send.reset.link');
});

// reset password
Route::group(['prefix' => 'password'], function () {
    Route::get('reset/{userId}/{code}', 'Auth\ResetPasswordController@showResetForm')
    	->name('auth.reset.password.form');

    Route::post('reset/{userId}/{code}', 'Auth\ResetPasswordController@reset')
    	->name('auth.reset.password');
});

// activation
Route::group(['prefix' => 'activation'], function () {
    Route::get('/{userId}/{code}', 'Auth\ActivationController@activation')
    	->name('auth.activation');
});

// change password
Route::group( [
	'middleware' => [
		'sentinel.permission:dashboard',
	]
], function () {
    Route::group(['prefix' => 'password'], function () {
        Route::get('change', 'Auth\ChangePasswordController@edit')
        	->name('auth.change.password.form');
        Route::post('change', 'Auth\ChangePasswordController@update')
        	->name('auth.change.password.action');
    });
});

// roles
Route::group( [
	'middleware' => [
		'prevent.back.history'
	],
	'prefix'     => 'roles'
], function () {
	Route::get('', 'Auth\RoleController@index')
	    ->name('roles.index')->middleware('sentinel.permission:role.show');
	
	Route::get('/create', 'Auth\RoleController@create')
	    ->name('roles.create')->middleware('sentinel.permission:role.create');
	
	Route::post('', 'Auth\RoleController@store')
	    ->name('roles.store')->middleware('sentinel.permission:role.create');
	
	Route::get('/{role}', 'Auth\RoleController@show')
	    ->name('roles.show')->middleware('sentinel.permission:role.show');
	
	Route::get('/{role}/edit', 'Auth\RoleController@edit')
	    ->name('roles.edit')->middleware('sentinel.permission:role.edit');
	
	Route::put('/{role}', 'Auth\RoleController@update')
	    ->name('roles.update')->middleware('sentinel.permission:role.edit');
	
	Route::delete('/{role}', 'Auth\RoleController@destroy')
	    ->name('roles.destroy')->middleware('sentinel.permission:role.destroy');
	
	Route::get('/ajax/data', 'Auth\RoleController@anyData')
	    ->name('roles.ajax.data')->middleware('sentinel.permission:role.show');

    Route::get('/ajax/select2', 'Auth\RoleController@select2')
       ->name('roles.ajax.select2');
} );

// users
Route::group( [
	'middleware' => [
		'prevent.back.history'
	],
	'prefix'     => 'users'
], function () {
	Route::get('', 'Auth\UserController@index')
	    ->name('users.index')->middleware( 'sentinel.permission:user.show');
	
	Route::get('/create', 'Auth\UserController@create')
	    ->name( 'users.create' )->middleware( 'sentinel.permission:user.create');
	
	Route::post('', 'Auth\UserController@store')
	    ->name('users.store')->middleware( 'sentinel.permission:user.create');
	
	Route::get('/{user}', 'Auth\UserController@show')
	    ->name('users.show')->middleware('sentinel.permission:user.show');
	
	Route::get('/{user}/edit', 'Auth\UserController@edit')
	    ->name('users.edit' )->middleware( 'sentinel.permission:user.edit');
	
	Route::put('/{user}', 'Auth\UserController@update')
	    ->name('users.update')->middleware( 'sentinel.permission:user.edit');
	
	Route::delete('/{user}', 'Auth\UserController@destroy')
	    ->name('users.destroy')->middleware('sentinel.permission:user.destroy');
	
	Route::get('/ajax/data', 'Auth\UserController@anyData')
	    ->name('users.ajax.data')->middleware('sentinel.permission:user.show');

    Route::get('/ajax/select2', 'Auth\UserController@select2')
       ->name('users.ajax.select2');

	Route::put('users/status/{id}', 'Auth\UserController@status')
	    ->name('users.status')->middleware('sentinel.permission:user.status');
});

// dashboard
Route::group([
    'middleware' => [
        'prevent.back.history',
        'sentinel.permission:dashboard'
    ],
    'prefix'     => '',
], function () {
    Route::get('/', 'Backend\DashboardController@index')
        ->name('dashboard');
});

Route::group(['prefix' => 'status'], function () {
	Route::get('', 'Auth\StatusController@showStatusForm')
		->name('status.form');
});

// about-us
Route::group([
    'middleware' => [
        'prevent.back.history'
    ],
    'prefix'     => 'about-us',
], function () {
    Route::get('', 'Backend\AboutUsController@index')
        ->name('about_us.index')->middleware('sentinel.permission:about_us.show');

    Route::get('/create', 'Backend\AboutUsController@create')
        ->name('about_us.create')->middleware('sentinel.permission:about_us.create');

    Route::post('', 'Backend\AboutUsController@store')
        ->name('about_us.store')->middleware('sentinel.permission:about_us.create');

    Route::get('/{id}/show', 'Backend\AboutUsController@show')
        ->name('about_us.show')->middleware('sentinel.permission:about_us.show');

    Route::get('/{id}/edit', 'Backend\AboutUsController@edit')
        ->name('about_us.edit')->middleware('sentinel.permission:about_us.edit');

    Route::put('/{id}', 'Backend\AboutUsController@update')
        ->name('about_us.update')->middleware('sentinel.permission:about_us.edit');

    Route::delete('/{id}', 'Backend\AboutUsController@destroy')
        ->name('about_us.destroy')->middleware('sentinel.permission:about_us.destroy');

    Route::get('/ajax/data', 'Backend\AboutUsController@datatable')
        ->name('about_us.ajax.data')->middleware('sentinel.permission:about_us.show');
});

// contact-us
Route::group([
    'middleware' => [
        'prevent.back.history'
    ],
    'prefix'     => 'contact-us',
], function () {
    Route::get('', 'Backend\ContactUsController@index')
        ->name('contact_us.index')->middleware('sentinel.permission:contact_us.show');

    Route::get('/create', 'Backend\ContactUsController@create')
        ->name('contact_us.create')->middleware('sentinel.permission:contact_us.create');

    Route::post('', 'Backend\ContactUsController@store')
        ->name('contact_us.store')->middleware('sentinel.permission:contact_us.create');

    Route::get('/{id}/show', 'Backend\ContactUsController@show')
        ->name('contact_us.show')->middleware('sentinel.permission:contact_us.show');

    Route::get('/{id}/edit', 'Backend\ContactUsController@edit')
        ->name('contact_us.edit')->middleware('sentinel.permission:contact_us.edit');

    Route::put('/{id}', 'Backend\ContactUsController@update')
        ->name('contact_us.update')->middleware('sentinel.permission:contact_us.edit');

    Route::delete('/{id}', 'Backend\ContactUsController@destroy')
        ->name('contact_us.destroy')->middleware('sentinel.permission:contact_us.destroy');

    Route::get('/ajax/data', 'Backend\ContactUsController@datatable')
        ->name('contact_us.ajax.data')->middleware('sentinel.permission:contact_us.show');
});

// disclaimer
Route::group([
    'middleware' => [
        'prevent.back.history'
    ],
    'prefix'     => 'disclaimer',
], function () {
    Route::get('', 'Backend\DisclaimerController@index')
        ->name('disclaimer.index')->middleware('sentinel.permission:disclaimer.show');

    Route::get('/create', 'Backend\DisclaimerController@create')
        ->name('disclaimer.create')->middleware('sentinel.permission:disclaimer.create');

    Route::post('', 'Backend\DisclaimerController@store')
        ->name('disclaimer.store')->middleware('sentinel.permission:disclaimer.create');

    Route::get('/{id}/show', 'Backend\DisclaimerController@show')
        ->name('disclaimer.show')->middleware('sentinel.permission:disclaimer.show');

    Route::get('/{id}/edit', 'Backend\DisclaimerController@edit')
        ->name('disclaimer.edit')->middleware('sentinel.permission:disclaimer.edit');

    Route::put('/{id}', 'Backend\DisclaimerController@update')
        ->name('disclaimer.update')->middleware('sentinel.permission:disclaimer.edit');

    Route::delete('/{id}', 'Backend\DisclaimerController@destroy')
        ->name('disclaimer.destroy')->middleware('sentinel.permission:disclaimer.destroy');

    Route::get('/ajax/data', 'Backend\DisclaimerController@datatable')
        ->name('disclaimer.ajax.data')->middleware('sentinel.permission:disclaimer.show');
});

// faq
Route::group([
    'middleware' => [
        'prevent.back.history'
    ],
    'prefix'     => 'faq',
], function () {
    Route::get('', 'Backend\FaqController@index')
        ->name('faq.index')->middleware('sentinel.permission:faq.show');

    Route::get('/create', 'Backend\FaqController@create')
        ->name('faq.create')->middleware('sentinel.permission:faq.create');

    Route::post('', 'Backend\FaqController@store')
        ->name('faq.store')->middleware('sentinel.permission:faq.create');

    Route::get('/{id}/show', 'Backend\FaqController@show')
        ->name('faq.show')->middleware('sentinel.permission:faq.show');

    Route::get('/{id}/edit', 'Backend\FaqController@edit')
        ->name('faq.edit')->middleware('sentinel.permission:faq.edit');

    Route::put('/{id}', 'Backend\FaqController@update')
        ->name('faq.update')->middleware('sentinel.permission:faq.edit');

    Route::delete('/{id}', 'Backend\FaqController@destroy')
        ->name('faq.destroy')->middleware('sentinel.permission:faq.destroy');

    Route::get('/ajax/data', 'Backend\FaqController@datatable')
        ->name('faq.ajax.data')->middleware('sentinel.permission:faq.show');
});

// media
Route::group([
    'middleware' => [
        'prevent.back.history'
    ],
    'prefix'     => 'media-kayabumbu',
], function () {
    Route::get('', 'Backend\MediaController@index')
        ->name('media.index')->middleware('sentinel.permission:media.show');

    Route::get('/create', 'Backend\MediaController@create')
        ->name('media.create')->middleware('sentinel.permission:media.create');

    Route::post('', 'Backend\MediaController@store')
        ->name('media.store')->middleware('sentinel.permission:media.create');

    Route::get('/{id}/show', 'Backend\MediaController@show')
        ->name('media.show')->middleware('sentinel.permission:media.show');

    Route::get('/{id}/edit', 'Backend\MediaController@edit')
        ->name('media.edit')->middleware('sentinel.permission:media.edit');

    Route::put('/{id}', 'Backend\MediaController@update')
        ->name('media.update')->middleware('sentinel.permission:media.edit');

    Route::delete('/{id}', 'Backend\MediaController@destroy')
        ->name('media.destroy')->middleware('sentinel.permission:media.destroy');

    Route::get('/ajax/data', 'Backend\MediaController@datatable')
        ->name('media.ajax.data')->middleware('sentinel.permission:media.show');
});

// news
Route::group([
    'middleware' => [
        'prevent.back.history'
    ],
    'prefix'     => 'news',
], function () {
    Route::get('', 'Backend\NewsController@index')
        ->name('news.index')->middleware('sentinel.permission:news.show');

    Route::get('/create', 'Backend\NewsController@create')
        ->name('news.create')->middleware('sentinel.permission:news.create');

    Route::post('', 'Backend\NewsController@store')
        ->name('news.store')->middleware('sentinel.permission:news.create');

    Route::get('/{id}/show', 'Backend\NewsController@show')
        ->name('news.show')->middleware('sentinel.permission:news.show');

    Route::get('/{id}/edit', 'Backend\NewsController@edit')
        ->name('news.edit')->middleware('sentinel.permission:news.edit');

    Route::put('/{id}', 'Backend\NewsController@update')
        ->name('news.update')->middleware('sentinel.permission:news.edit');

    Route::delete('/{id}', 'Backend\NewsController@destroy')
        ->name('news.destroy')->middleware('sentinel.permission:news.destroy');

    Route::get('/ajax/data', 'Backend\NewsController@datatable')
        ->name('news.ajax.data')->middleware('sentinel.permission:news.show');
});

// privacy-policy
Route::group([
    'middleware' => [
        'prevent.back.history'
    ],
    'prefix'     => 'privacy-policy',
], function () {
    Route::get('', 'Backend\PrivacyPolicyController@index')
        ->name('privacy_policy.index')->middleware('sentinel.permission:privacy_policy.show');

    Route::get('/create', 'Backend\PrivacyPolicyController@create')
        ->name('privacy_policy.create')->middleware('sentinel.permission:privacy_policy.create');

    Route::post('', 'Backend\PrivacyPolicyController@store')
        ->name('privacy_policy.store')->middleware('sentinel.permission:privacy_policy.create');

    Route::get('/{id}/show', 'Backend\PrivacyPolicyController@show')
        ->name('privacy_policy.show')->middleware('sentinel.permission:privacy_policy.show');

    Route::get('/{id}/edit', 'Backend\PrivacyPolicyController@edit')
        ->name('privacy_policy.edit')->middleware('sentinel.permission:privacy_policy.edit');

    Route::put('/{id}', 'Backend\PrivacyPolicyController@update')
        ->name('privacy_policy.update')->middleware('sentinel.permission:privacy_policy.edit');

    Route::delete('/{id}', 'Backend\PrivacyPolicyController@destroy')
        ->name('privacy_policy.destroy')->middleware('sentinel.permission:privacy_policy.destroy');

    Route::get('/ajax/data', 'Backend\PrivacyPolicyController@datatable')
        ->name('privacy_policy.ajax.data')->middleware('sentinel.permission:privacy_policy.show');
});

// term-condition
Route::group([
    'middleware' => [
        'prevent.back.history'
    ],
    'prefix'     => 'term-condition',
], function () {
    Route::get('', 'Backend\TermConditionController@index')
        ->name('term_condition.index')->middleware('sentinel.permission:term_condition.show');

    Route::get('/create', 'Backend\TermConditionController@create')
        ->name('term_condition.create')->middleware('sentinel.permission:term_condition.create');

    Route::post('', 'Backend\TermConditionController@store')
        ->name('term_condition.store')->middleware('sentinel.permission:term_condition.create');

    Route::get('/{id}/show', 'Backend\TermConditionController@show')
        ->name('term_condition.show')->middleware('sentinel.permission:term_condition.show');

    Route::get('/{id}/edit', 'Backend\TermConditionController@edit')
        ->name('term_condition.edit')->middleware('sentinel.permission:term_condition.edit');

    Route::put('/{id}', 'Backend\TermConditionController@update')
        ->name('term_condition.update')->middleware('sentinel.permission:term_condition.edit');

    Route::delete('/{id}', 'Backend\TermConditionController@destroy')
        ->name('term_condition.destroy')->middleware('sentinel.permission:term_condition.destroy');

    Route::get('/ajax/data', 'Backend\TermConditionController@datatable')
        ->name('term_condition.ajax.data')->middleware('sentinel.permission:term_condition.show');
});

// ingredient
Route::group([
    'middleware' => [
        'prevent.back.history'
    ],
    'prefix'     => 'ingredient',
], function () {
    Route::get('', 'Backend\IngredientController@index')
        ->name('ingredient.index')->middleware('sentinel.permission:ingredient.show');

    Route::get('/create', 'Backend\IngredientController@create')
        ->name('ingredient.create')->middleware('sentinel.permission:ingredient.create');

    Route::post('', 'Backend\IngredientController@store')
        ->name('ingredient.store')->middleware('sentinel.permission:ingredient.create');

    Route::get('/{id}/show', 'Backend\IngredientController@show')
        ->name('ingredient.show')->middleware('sentinel.permission:ingredient.show');

    Route::get('/{id}/edit', 'Backend\IngredientController@edit')
        ->name('ingredient.edit')->middleware('sentinel.permission:ingredient.edit');

    Route::put('/{id}', 'Backend\IngredientController@update')
        ->name('ingredient.update')->middleware('sentinel.permission:ingredient.edit');

    Route::delete('/{id}', 'Backend\IngredientController@destroy')
        ->name('ingredient.destroy')->middleware('sentinel.permission:ingredient.destroy');

    Route::get('/ajax/data', 'Backend\IngredientController@datatable')
        ->name('ingredient.ajax.data')->middleware('sentinel.permission:ingredient.show');

    Route::get('/ajax/select2', 'Backend\IngredientController@select2')
        ->name('ingredient.ajax.select2');
});

// product
Route::group([
    'middleware' => [
        'prevent.back.history'
    ],
    'prefix'     => 'product',
], function () {
    Route::get('', 'Backend\ProductController@index')
        ->name('product.index')->middleware('sentinel.permission:product.show');

    Route::get('/create', 'Backend\ProductController@create')
        ->name('product.create')->middleware('sentinel.permission:product.create');

    Route::post('', 'Backend\ProductController@store')
        ->name('product.store')->middleware('sentinel.permission:product.create');

    Route::get('/{id}/show', 'Backend\ProductController@show')
        ->name('product.show')->middleware('sentinel.permission:product.show');

    Route::get('/{id}/edit', 'Backend\ProductController@edit')
        ->name('product.edit')->middleware('sentinel.permission:product.edit');

    Route::put('/{id}', 'Backend\ProductController@update')
        ->name('product.update')->middleware('sentinel.permission:product.edit');

    Route::delete('/{id}', 'Backend\ProductController@destroy')
        ->name('product.destroy')->middleware('sentinel.permission:product.destroy');

    Route::get('/ajax/data', 'Backend\ProductController@datatable')
        ->name('product.ajax.data')->middleware('sentinel.permission:product.show');

    Route::get('/ajax/select2', 'Backend\ProductController@select2')
        ->name('product.ajax.select2');
});

// transaction
Route::group([
    'middleware' => [
        'prevent.back.history'
    ],
    'prefix'     => 'transaction',
], function () {
    Route::get('', 'Backend\TransactionController@index')
        ->name('transaction.index')->middleware('sentinel.permission:transaction.show');

    Route::get('/create', 'Backend\TransactionController@create')
        ->name('transaction.create')->middleware('sentinel.permission:transaction.create');

    Route::post('', 'Backend\TransactionController@store')
        ->name('transaction.store')->middleware('sentinel.permission:transaction.create');

    Route::get('/{id}/show', 'Backend\TransactionController@show')
        ->name('transaction.show')->middleware('sentinel.permission:transaction.show');

    Route::delete('/{id}', 'Backend\TransactionController@destroy')
        ->name('transaction.destroy')->middleware('sentinel.permission:transaction.destroy');

    Route::get('/ajax/data', 'Backend\TransactionController@datatable')
        ->name('transaction.ajax.data')->middleware('sentinel.permission:transaction.show');
});

// log
Route::group([
    'middleware' => [
        'prevent.back.history'
    ],
    'prefix'     => 'log',
], function () {
    Route::get('', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->middleware('sentinel.permission:log.show');
});