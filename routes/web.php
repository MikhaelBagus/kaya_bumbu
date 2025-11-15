<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ActivationController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\RoleController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\StatusController;
use App\Http\Controllers\Backend\AboutUsController;
use App\Http\Controllers\Backend\BankController;
use App\Http\Controllers\Backend\CalendarController;
use App\Http\Controllers\Backend\CityController;
use App\Http\Controllers\Backend\ContactUsController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\DisclaimerController;
use App\Http\Controllers\Backend\DriverController;
use App\Http\Controllers\Backend\FaqController;
use App\Http\Controllers\Backend\LogController;
use App\Http\Controllers\Backend\MediaController;
use App\Http\Controllers\Backend\NewsController;
use App\Http\Controllers\Backend\PrivacyPolicyController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ProductCategoryController;
use App\Http\Controllers\Backend\ProductRankingController;
use App\Http\Controllers\Backend\ProvinceController;
use App\Http\Controllers\Backend\SourceController;
use App\Http\Controllers\Backend\TermConditionController;
use App\Http\Controllers\Backend\TransactionController;
use App\Http\Controllers\Backend\ImportController;
use App\Http\Controllers\Backend\TransactionDownloadController;
use \Rap2hpoutre\LaravelLogViewer\LogViewerController;
use App\Http\Controllers\Backend\ProductRecipeController;
use App\Http\Controllers\Backend\IngredientMasterController;
use App\Http\Controllers\Backend\IngredientCategoryController;
use App\Http\Middleware\PreventBackHistory;
use App\Http\Middleware\SentinelPermission;

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
	Route::get('', [LoginController::class, "showLoginForm"])
		->name('login.form');

	Route::post('/process', [LoginController::class, "login"])
		->name('login.process')->middleware('prevent.back.history');
});

// logout
Route::group(['prefix' => '/logout'], function () {
	Route::get('', [LoginController::class, "logout"])
		->name('logout')->middleware('prevent.back.history');
});

// forgot password
// Route::group(['prefix' => 'password'], function () {
//     Route::get('forgot', [ForgotPasswordController::class, "index"])
//     	->name('auth.forgot.password.form');

//     Route::post('send-reset-link', [ForgotPasswordController::class, "sendResetLinkResponse"])
//     	->name('auth.forgot.password.send.reset.link');
// });

// reset password
// Route::group(['prefix' => 'password'], function () {
//     Route::get('reset/{userId}/{code}', [ResetPasswordController::class, "showResetForm"])
//     	->name('auth.reset.password.form');

//     Route::post('reset/{userId}/{code}', [ResetPasswordController::class, "reset"])
//     	->name('auth.reset.password');
// });

// activation
// Route::group(['prefix' => 'activation'], function () {
//     Route::get('/{userId}/{code}', [ActivationController::class, "activation"])
//     	->name('auth.activation');
// });

// change password
Route::group( [
	'middleware' => [
		'sentinel.permission:dashboard',
	]
], function () {
    Route::group(['prefix' => 'password'], function () {
        Route::get('change', [ChangePasswordController::class, 'edit'])
        	->name('auth.change.password.form');
        Route::post('change', [ChangePasswordController::class, 'update'])
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
	Route::get('', [RoleController::class, 'index'])
	    ->name('roles.index')->middleware('sentinel.permission:role.show');
	
	Route::get('/create', [RoleController::class, 'create'])
	    ->name('roles.create')->middleware('sentinel.permission:role.create');
	
	Route::post('', [RoleController::class, 'store'])
	    ->name('roles.store')->middleware('sentinel.permission:role.create');
	
	Route::get('/{role}', [RoleController::class, 'show'])
	    ->name('roles.show')->middleware('sentinel.permission:role.show');
	
	Route::get('/{role}/edit', [RoleController::class, 'edit'])
	    ->name('roles.edit')->middleware('sentinel.permission:role.edit');
	
	Route::put('/{role}', [RoleController::class, 'update'])
	    ->name('roles.update')->middleware('sentinel.permission:role.edit');
	
	Route::delete('/{role}', [RoleController::class, 'destroy'])
	    ->name('roles.destroy')->middleware('sentinel.permission:role.destroy');
	
	Route::get('/ajax/data', [RoleController::class, 'anyData'])
	    ->name('roles.ajax.data')->middleware('sentinel.permission:role.show');

    Route::get('/ajax/select2', [RoleController::class, 'select2'])
       ->name('roles.ajax.select2');
} );

// users
Route::group( [
	'middleware' => [
		'prevent.back.history'
	],
	'prefix'     => 'users'
], function () {
	Route::get('', [UserController::class, 'index'])
	    ->name('users.index')->middleware('sentinel.permission:user.show');
	
	Route::get('/create', [UserController::class, 'create'])
	    ->name( 'users.create' )->middleware('sentinel.permission:user.create');
	
	Route::post('', [UserController::class, 'store'])
	    ->name('users.store')->middleware('sentinel.permission:user.create');
	
	Route::get('/{user}', [UserController::class, 'show'])
	    ->name('users.show')->middleware('sentinel.permission:user.show');
	
	Route::get('/{user}/edit', [UserController::class, 'edit'])
	    ->name('users.edit' )->middleware('sentinel.permission:user.edit');
	
	Route::put('/{user}', [UserController::class, 'update'])
	    ->name('users.update')->middleware('sentinel.permission:user.edit');
	
	Route::delete('/{user}', [UserController::class, 'destroy'])
	    ->name('users.destroy')->middleware('sentinel.permission:user.destroy');
	
	Route::get('/ajax/data', [UserController::class, 'anyData'])
	    ->name('users.ajax.data')->middleware('sentinel.permission:user.show');

    Route::get('/ajax/select2', [UserController::class, 'select2'])
       ->name('users.ajax.select2');

	Route::put('users/status/{id}', [UserController::class, 'status'])
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
    Route::get('/', [DashboardController::class, "index"])
        ->name('dashboard');
});

Route::group(['prefix' => 'status'], function () {
	Route::get('', [StatusController::class, "showStatusForm"])
		->name('status.form');
});

// about-us
Route::group([
    'middleware' => [
        'prevent.back.history'
    ],
    'prefix'     => 'about-us',
], function () {
    Route::get('', [AboutUsController::class, 'index'])
        ->name('about_us.index')->middleware('sentinel.permission:about_us.show');

    Route::get('/create', [AboutUsController::class, 'create'])
        ->name('about_us.create')->middleware('sentinel.permission:about_us.create');

    Route::post('', [AboutUsController::class, 'store'])
        ->name('about_us.store')->middleware('sentinel.permission:about_us.create');

    Route::get('/{id}/show', [AboutUsController::class, 'show'])
        ->name('about_us.show')->middleware('sentinel.permission:about_us.show');

    Route::get('/{id}/edit', [AboutUsController::class, 'edit'])
        ->name('about_us.edit')->middleware('sentinel.permission:about_us.edit');

    Route::put('/{id}', [AboutUsController::class, 'update'])
        ->name('about_us.update')->middleware('sentinel.permission:about_us.edit');

    Route::delete('/{id}', [AboutUsController::class, 'destroy'])
        ->name('about_us.destroy')->middleware('sentinel.permission:about_us.destroy');

    Route::get('/ajax/data', [AboutUsController::class, 'datatable'])
        ->name('about_us.ajax.data')->middleware('sentinel.permission:about_us.show');
});

// contact-us
Route::group([
    'middleware' => [
        'prevent.back.history'
    ],
    'prefix'     => 'contact-us',
], function () {
    Route::get('', [ContactUsController::class, 'index'])
        ->name('contact_us.index')->middleware('sentinel.permission:contact_us.show');

    Route::get('/create', [ContactUsController::class, 'create'])
        ->name('contact_us.create')->middleware('sentinel.permission:contact_us.create');

    Route::post('', [ContactUsController::class, 'store'])
        ->name('contact_us.store')->middleware('sentinel.permission:contact_us.create');

    Route::get('/{id}/show', [ContactUsController::class, 'show'])
        ->name('contact_us.show')->middleware('sentinel.permission:contact_us.show');

    Route::get('/{id}/edit', [ContactUsController::class, 'edit'])
        ->name('contact_us.edit')->middleware('sentinel.permission:contact_us.edit');

    Route::put('/{id}', [ContactUsController::class, 'update'])
        ->name('contact_us.update')->middleware('sentinel.permission:contact_us.edit');

    Route::delete('/{id}', [ContactUsController::class, 'destroy'])
        ->name('contact_us.destroy')->middleware('sentinel.permission:contact_us.destroy');

    Route::get('/ajax/data', [ContactUsController::class, 'datatable'])
        ->name('contact_us.ajax.data')->middleware('sentinel.permission:contact_us.show');
});

// disclaimer
Route::group([
    // 'middleware' => [
    //     'prevent.back.history'
    // ],
    'prefix'     => 'disclaimer',
], function () {
    Route::get('', [DisclaimerController::class, 'index'])
        ->name('disclaimer.index')->middleware('sentinel.permission:disclaimer.show');

    Route::get('/create', [DisclaimerController::class, 'create'])
        ->name('disclaimer.create')->middleware('sentinel.permission:disclaimer.create');

    Route::post('', [DisclaimerController::class, 'store'])
        ->name('disclaimer.store')->middleware('sentinel.permission:disclaimer.create');

    Route::get('/{id}/show', [DisclaimerController::class, 'show'])
        ->name('disclaimer.show')->middleware('sentinel.permission:disclaimer.show');

    Route::get('/{id}/edit', [DisclaimerController::class, 'edit'])
        ->name('disclaimer.edit')->middleware('sentinel.permission:disclaimer.edit');

    Route::put('/{id}', [DisclaimerController::class, 'update'])
        ->name('disclaimer.update')->middleware('sentinel.permission:disclaimer.edit');

    Route::delete('/{id}', [DisclaimerController::class, 'destroy'])
        ->name('disclaimer.destroy')->middleware('sentinel.permission:disclaimer.destroy');

    Route::get('/ajax/data', [DisclaimerController::class, 'datatable'])
        ->name('disclaimer.ajax.data')->middleware('sentinel.permission:disclaimer.show');
});

// faq
Route::group([
    'middleware' => [
        'prevent.back.history'
    ],
    'prefix'     => 'faq',
], function () {
    Route::get('', [FaqController::class, 'index'])
        ->name('faq.index')->middleware('sentinel.permission:faq.show');

    Route::get('/create', [FaqController::class, 'create'])
        ->name('faq.create')->middleware('sentinel.permission:faq.create');

    Route::post('', [FaqController::class, 'store'])
        ->name('faq.store')->middleware('sentinel.permission:faq.create');

    Route::get('/{id}/show', [FaqController::class, 'show'])
        ->name('faq.show')->middleware('sentinel.permission:faq.show');

    Route::get('/{id}/edit', [FaqController::class, 'edit'])
        ->name('faq.edit')->middleware('sentinel.permission:faq.edit');

    Route::put('/{id}', [FaqController::class, 'update'])
        ->name('faq.update')->middleware('sentinel.permission:faq.edit');

    Route::delete('/{id}', [FaqController::class, 'destroy'])
        ->name('faq.destroy')->middleware('sentinel.permission:faq.destroy');

    Route::get('/ajax/data', [FaqController::class, 'datatable'])
        ->name('faq.ajax.data')->middleware('sentinel.permission:faq.show');
});

// media
Route::group([
    'middleware' => [
        'prevent.back.history'
    ],
    'prefix'     => 'media-kayabumbu',
], function () {
    Route::get('', [MediaController::class, 'index'])
        ->name('media.index')->middleware('sentinel.permission:media.show');

    Route::get('/create', [MediaController::class, 'create'])
        ->name('media.create')->middleware('sentinel.permission:media.create');

    Route::post('', [MediaController::class, 'store'])
        ->name('media.store')->middleware('sentinel.permission:media.create');

    Route::get('/{id}/show', [MediaController::class, 'show'])
        ->name('media.show')->middleware('sentinel.permission:media.show');

    Route::get('/{id}/edit', [MediaController::class, 'edit'])
        ->name('media.edit')->middleware('sentinel.permission:media.edit');

    Route::put('/{id}', [MediaController::class, 'update'])
        ->name('media.update')->middleware('sentinel.permission:media.edit');

    Route::delete('/{id}', [MediaController::class, 'destroy'])
        ->name('media.destroy')->middleware('sentinel.permission:media.destroy');

    Route::get('/ajax/data', [MediaController::class, 'datatable'])
        ->name('media.ajax.data')->middleware('sentinel.permission:media.show');
});

// news
Route::group([
    'middleware' => [
        'prevent.back.history'
    ],
    'prefix'     => 'news',
], function () {
    Route::get('', [NewsController::class, 'index'])
        ->name('news.index')->middleware('sentinel.permission:news.show');

    Route::get('/create', [NewsController::class, 'create'])
        ->name('news.create')->middleware('sentinel.permission:news.create');

    Route::post('', [NewsController::class, 'store'])
        ->name('news.store')->middleware('sentinel.permission:news.create');

    Route::get('/{id}/show', [NewsController::class, 'show'])
        ->name('news.show')->middleware('sentinel.permission:news.show');

    Route::get('/{id}/edit', [NewsController::class, 'edit'])
        ->name('news.edit')->middleware('sentinel.permission:news.edit');

    Route::put('/{id}', [NewsController::class, 'update'])
        ->name('news.update')->middleware('sentinel.permission:news.edit');

    Route::delete('/{id}', [NewsController::class, 'destroy'])
        ->name('news.destroy')->middleware('sentinel.permission:news.destroy');

    Route::get('/ajax/data', [NewsController::class, 'datatable'])
        ->name('news.ajax.data')->middleware('sentinel.permission:news.show');
});

// privacy-policy
Route::group([
    'middleware' => [
        'prevent.back.history'
    ],
    'prefix'     => 'privacy-policy',
], function () {
    Route::get('', [PrivacyPolicyController::class, 'index'])
        ->name('privacy_policy.index')->middleware('sentinel.permission:privacy_policy.show');

    Route::get('/create', [PrivacyPolicyController::class, 'create'])
        ->name('privacy_policy.create')->middleware('sentinel.permission:privacy_policy.create');

    Route::post('', [PrivacyPolicyController::class, 'store'])
        ->name('privacy_policy.store')->middleware('sentinel.permission:privacy_policy.create');

    Route::get('/{id}/show', [PrivacyPolicyController::class, 'show'])
        ->name('privacy_policy.show')->middleware('sentinel.permission:privacy_policy.show');

    Route::get('/{id}/edit', [PrivacyPolicyController::class, 'edit'])
        ->name('privacy_policy.edit')->middleware('sentinel.permission:privacy_policy.edit');

    Route::put('/{id}', [PrivacyPolicyController::class, 'update'])
        ->name('privacy_policy.update')->middleware('sentinel.permission:privacy_policy.edit');

    Route::delete('/{id}', [PrivacyPolicyController::class, 'destroy'])
        ->name('privacy_policy.destroy')->middleware('sentinel.permission:privacy_policy.destroy');

    Route::get('/ajax/data', [PrivacyPolicyController::class, 'datatable'])
        ->name('privacy_policy.ajax.data')->middleware('sentinel.permission:privacy_policy.show');
});

// term-condition
Route::group([
    'middleware' => [
        'prevent.back.history'
    ],
    'prefix'     => 'term-condition',
], function () {
    Route::get('', [TermConditionController::class, 'index'])
        ->name('term_condition.index')->middleware('sentinel.permission:term_condition.show');

    Route::get('/create', [TermConditionController::class, 'create'])
        ->name('term_condition.create')->middleware('sentinel.permission:term_condition.create');

    Route::post('', [TermConditionController::class, 'store'])
        ->name('term_condition.store')->middleware('sentinel.permission:term_condition.create');

    Route::get('/{id}/show', [TermConditionController::class, 'show'])
        ->name('term_condition.show')->middleware('sentinel.permission:term_condition.show');

    Route::get('/{id}/edit', [TermConditionController::class, 'edit'])
        ->name('term_condition.edit')->middleware('sentinel.permission:term_condition.edit');

    Route::put('/{id}', [TermConditionController::class, 'update'])
        ->name('term_condition.update')->middleware('sentinel.permission:term_condition.edit');

    Route::delete('/{id}', [TermConditionController::class, 'destroy'])
        ->name('term_condition.destroy')->middleware('sentinel.permission:term_condition.destroy');

    Route::get('/ajax/data', [TermConditionController::class, 'datatable'])
        ->name('term_condition.ajax.data')->middleware('sentinel.permission:term_condition.show');
});

// log
Route::group([
    'middleware' => [
        'prevent.back.history'
    ],
    'prefix'     => 'log',
], function () {
    Route::get('', [LogController::class, 'index'])
        ->name('log.index')->middleware('sentinel.permission:log.show');

    Route::get('/ajax/data', [LogController::class, 'datatable'])
        ->name('log.ajax.data')->middleware('sentinel.permission:log.show');
});

// province
Route::group([
    'middleware' => [
        'prevent.back.history'
    ],
    'prefix'     => 'province',
], function () {
    Route::get('', [ProvinceController::class, 'index'])
        ->name('province.index')->middleware('sentinel.permission:province.show');

    Route::get('/create', [ProvinceController::class, 'create'])
        ->name('province.create')->middleware('sentinel.permission:province.create');

    Route::post('', [ProvinceController::class, 'store'])
        ->name('province.store')->middleware('sentinel.permission:province.create');

    Route::get('/{id}/show', [ProvinceController::class, 'show'])
        ->name('province.show')->middleware('sentinel.permission:province.show');

    Route::get('/{id}/edit', [ProvinceController::class, 'edit'])
        ->name('province.edit')->middleware('sentinel.permission:province.edit');

    Route::put('/{id}', [ProvinceController::class, 'update'])
        ->name('province.update')->middleware('sentinel.permission:province.edit');

    Route::delete('/{id}', [ProvinceController::class, 'destroy'])
        ->name('province.destroy')->middleware('sentinel.permission:province.destroy');

    Route::get('/ajax/data', [ProvinceController::class, 'datatable'])
        ->name('province.ajax.data')->middleware('sentinel.permission:province.show');

    Route::get('/ajax/select2', [ProvinceController::class, 'select2'])
        ->name('province.ajax.select2');
});

// city
Route::group([
    'middleware' => [
        'prevent.back.history'
    ],
    'prefix'     => 'city',
], function () {
    Route::get('', [CityController::class, 'index'])
        ->name('city.index')->middleware('sentinel.permission:city.show');

    Route::get('/create', [CityController::class, 'create'])
        ->name('city.create')->middleware('sentinel.permission:city.create');

    Route::post('', [CityController::class, 'store'])
        ->name('city.store')->middleware('sentinel.permission:city.create');

    Route::get('/{id}/show', [CityController::class, 'show'])
        ->name('city.show')->middleware('sentinel.permission:city.show');

    Route::get('/{id}/edit', [CityController::class, 'edit'])
        ->name('city.edit')->middleware('sentinel.permission:city.edit');

    Route::put('/{id}', [CityController::class, 'update'])
        ->name('city.update')->middleware('sentinel.permission:city.edit');

    Route::delete('/{id}', [CityController::class, 'destroy'])
        ->name('city.destroy')->middleware('sentinel.permission:city.destroy');

    Route::get('/ajax/data', [CityController::class, 'datatable'])
        ->name('city.ajax.data')->middleware('sentinel.permission:city.show');

    Route::get('/ajax/select2', [CityController::class, 'select2'])
        ->name('city.ajax.select2');
});

// calendar
Route::group([
    'middleware' => [
        'prevent.back.history'
    ],
    'prefix'     => 'calendar',
], function () {
    Route::get('', [CalendarController::class, 'index'])
        ->name('calendar.index')->middleware('sentinel.permission:calendar.show');

    Route::get('/show/{month}/{year}', [CalendarController::class, 'show'])
        ->name('calendar.show')->middleware('sentinel.permission:calendar.show');

    Route::get('/detail-show/{month}/{year}/{date}/{hour}', [CalendarController::class, 'showDetail'])
        ->name('calendar.show_detail')->middleware('sentinel.permission:calendar.show');
});

// product_ranking
Route::group([
    'middleware' => [
        'prevent.back.history'
    ],
    'prefix'     => 'ranking-product',
], function () {
    Route::get('', [ProductRankingController::class, 'index'])
        ->name('product_ranking.index')->middleware('sentinel.permission:product_ranking.show');

    Route::get('/show/{month}/{year}', [ProductRankingController::class, 'show'])
        ->name('product_ranking.show')->middleware('sentinel.permission:product_ranking.show');

    Route::get('/ajax/data', [ProductRankingController::class, 'datatable'])
        ->name('product_ranking.ajax.data')->middleware('sentinel.permission:product_ranking.show');

    Route::get('/total/data', [ProductRankingController::class, 'total'])
        ->name('product_ranking.total_data')->middleware('sentinel.permission:product_ranking.show');
});

// bank
Route::group([
    'middleware' => [
        'prevent.back.history'
    ],
    'prefix'     => 'bank',
], function () {
    Route::get('', [BankController::class, 'index'])
        ->name('bank.index')->middleware('sentinel.permission:bank.show');

    Route::get('/create', [BankController::class, 'create'])
        ->name('bank.create')->middleware('sentinel.permission:bank.create');

    Route::post('', [BankController::class, 'store'])
        ->name('bank.store')->middleware('sentinel.permission:bank.create');

    Route::get('/{id}/show', [BankController::class, 'show'])
        ->name('bank.show')->middleware('sentinel.permission:bank.show');

    Route::get('/{id}/edit', [BankController::class, 'edit'])
        ->name('bank.edit')->middleware('sentinel.permission:bank.edit');

    Route::put('/{id}', [BankController::class, 'update'])
        ->name('bank.update')->middleware('sentinel.permission:bank.edit');

    Route::delete('/{id}', [BankController::class, 'destroy'])
        ->name('bank.destroy')->middleware('sentinel.permission:bank.destroy');

    Route::get('/ajax/data', [BankController::class, 'datatable'])
        ->name('bank.ajax.data')->middleware('sentinel.permission:bank.show');

    Route::get('/ajax/select2', [BankController::class, 'select2'])
        ->name('bank.ajax.select2');
});

// source
Route::group([
    'middleware' => [
        'prevent.back.history'
    ],
    'prefix'     => 'source',
], function () {
    Route::get('', [SourceController::class, 'index'])
        ->name('source.index')->middleware('sentinel.permission:source.show');

    Route::get('/create', [SourceController::class, 'create'])
        ->name('source.create')->middleware('sentinel.permission:source.create');

    Route::post('', [SourceController::class, 'store'])
        ->name('source.store')->middleware('sentinel.permission:source.create');

    Route::get('/{id}/show', [SourceController::class, 'show'])
        ->name('source.show')->middleware('sentinel.permission:source.show');

    Route::get('/{id}/edit', [SourceController::class, 'edit'])
        ->name('source.edit')->middleware('sentinel.permission:source.edit');

    Route::put('/{id}', [SourceController::class, 'update'])
        ->name('source.update')->middleware('sentinel.permission:source.edit');

    Route::delete('/{id}', [SourceController::class, 'destroy'])
        ->name('source.destroy')->middleware('sentinel.permission:source.destroy');

    Route::get('/ajax/data', [SourceController::class, 'datatable'])
        ->name('source.ajax.data')->middleware('sentinel.permission:source.show');

    Route::get('/ajax/select2', [SourceController::class, 'select2'])
        ->name('source.ajax.select2');
});

// customer
Route::group([
    'middleware' => [
        'prevent.back.history'
    ],
    'prefix'     => 'customer',
], function () {
    Route::get('', [CustomerController::class, 'index'])
        ->name('customer.index')->middleware('sentinel.permission:customer.show');

    Route::get('/create', [CustomerController::class, 'create'])
        ->name('customer.create')->middleware('sentinel.permission:customer.create');

    Route::post('', [CustomerController::class, 'store'])
        ->name('customer.store')->middleware('sentinel.permission:customer.create');

    Route::get('/{id}/show', [CustomerController::class, 'show'])
        ->name('customer.show')->middleware('sentinel.permission:customer.show');

    Route::get('/{id}/edit', [CustomerController::class, 'edit'])
        ->name('customer.edit')->middleware('sentinel.permission:customer.edit');

    Route::put('/{id}', [CustomerController::class, 'update'])
        ->name('customer.update')->middleware('sentinel.permission:customer.edit');

    Route::delete('/{id}', [CustomerController::class, 'destroy'])
        ->name('customer.destroy')->middleware('sentinel.permission:customer.destroy');

    Route::get('/ajax/data', [CustomerController::class, 'datatable'])
        ->name('customer.ajax.data')->middleware('sentinel.permission:customer.show');

    Route::get('/ajax/select2', [CustomerController::class, 'select2'])
        ->name('customer.ajax.select2');
});

// driver
Route::group([
    'middleware' => [
        'prevent.back.history'
    ],
    'prefix'     => 'driver',
], function () {
    Route::get('', [DriverController::class, 'index'])
        ->name('driver.index')->middleware('sentinel.permission:driver.show');

    Route::get('/create', [DriverController::class, 'create'])
        ->name('driver.create')->middleware('sentinel.permission:driver.create');

    Route::post('', [DriverController::class, 'store'])
        ->name('driver.store')->middleware('sentinel.permission:driver.create');

    Route::get('/{id}/show', [DriverController::class, 'show'])
        ->name('driver.show')->middleware('sentinel.permission:driver.show');

    Route::get('/{id}/edit', [DriverController::class, 'edit'])
        ->name('driver.edit')->middleware('sentinel.permission:driver.edit');

    Route::put('/{id}', [DriverController::class, 'update'])
        ->name('driver.update')->middleware('sentinel.permission:driver.edit');

    Route::delete('/{id}', [DriverController::class, 'destroy'])
        ->name('driver.destroy')->middleware('sentinel.permission:driver.destroy');

    Route::get('/ajax/data', [DriverController::class, 'datatable'])
        ->name('driver.ajax.data')->middleware('sentinel.permission:driver.show');

    Route::get('/ajax/select2', [DriverController::class, 'select2'])
        ->name('driver.ajax.select2');
});

// category-product
Route::group([
    'middleware' => [
        'prevent.back.history'
    ],
    'prefix'     => 'category-product',
], function () {
    Route::get('', [ProductCategoryController::class, 'index'])
        ->name('product_category.index')->middleware('sentinel.permission:product_category.show');

    Route::get('/create', [ProductCategoryController::class, 'create'])
        ->name('product_category.create')->middleware('sentinel.permission:product_category.create');

    Route::post('', [ProductCategoryController::class, 'store'])
        ->name('product_category.store')->middleware('sentinel.permission:product_category.create');

    Route::get('/{id}/show', [ProductCategoryController::class, 'show'])
        ->name('product_category.show')->middleware('sentinel.permission:product_category.show');

    Route::get('/{id}/edit', [ProductCategoryController::class, 'edit'])
        ->name('product_category.edit')->middleware('sentinel.permission:product_category.edit');

    Route::put('/{id}', [ProductCategoryController::class, 'update'])
        ->name('product_category.update')->middleware('sentinel.permission:product_category.edit');

    Route::delete('/{id}', [ProductCategoryController::class, 'destroy'])
        ->name('product_category.destroy')->middleware('sentinel.permission:product_category.destroy');

    Route::get('/ajax/data', [ProductCategoryController::class, 'datatable'])
        ->name('product_category.ajax.data')->middleware('sentinel.permission:product_category.show');

    Route::get('/ajax/select2', [ProductCategoryController::class, 'select2'])
        ->name('product_category.ajax.select2');

    Route::get('/{id}/copy', [ProductCategoryController::class, 'copy'])
        ->name('product_category.copy')->middleware('sentinel.permission:product_category.copy');
});

// category-ingredient
Route::group([
    'middleware' => [
        'prevent.back.history'
    ],
    'prefix'     => 'category-ingredient',
], function () {
    Route::get('', [IngredientCategoryController::class, 'index'])
        ->name('ingredient_category.index')->middleware('sentinel.permission:ingredient_category.show');

    Route::get('/create', [IngredientCategoryController::class, 'create'])
        ->name('ingredient_category.create')->middleware('sentinel.permission:ingredient_category.create');

    Route::post('', [IngredientCategoryController::class, 'store'])
        ->name('ingredient_category.store')->middleware('sentinel.permission:ingredient_category.create');

    Route::get('/{id}/show', [IngredientCategoryController::class, 'show'])
        ->name('ingredient_category.show')->middleware('sentinel.permission:ingredient_category.show');

    Route::get('/{id}/edit', [IngredientCategoryController::class, 'edit'])
        ->name('ingredient_category.edit')->middleware('sentinel.permission:ingredient_category.edit');

    Route::put('/{id}', [IngredientCategoryController::class, 'update'])
        ->name('ingredient_category.update')->middleware('sentinel.permission:ingredient_category.edit');

    Route::delete('/{id}', [IngredientCategoryController::class, 'destroy'])
        ->name('ingredient_category.destroy')->middleware('sentinel.permission:ingredient_category.destroy');

    Route::get('/ajax/data', [IngredientCategoryController::class, 'datatable'])
        ->name('ingredient_category.ajax.data')->middleware('sentinel.permission:ingredient_category.show');

    Route::get('/ajax/select2', [IngredientCategoryController::class, 'select2'])
        ->name('ingredient_category.ajax.select2');

    Route::get('/{id}/copy', [IngredientCategoryController::class, 'copy'])
        ->name('ingredient_category.copy')->middleware('sentinel.permission:ingredient_category.copy');
});

Route::group([
    'middleware' => [
        'prevent.back.history'
    ],
    'prefix' => 'ingredient',
], function () {
    Route::get('', [IngredientMasterController::class, 'index'])
        ->name('ingredient.index')->middleware('sentinel.permission:ingredient.show');

    Route::get('/create', [IngredientMasterController::class, 'create'])
        ->name('ingredient.create')->middleware('sentinel.permission:ingredient.create');

    Route::post('', [IngredientMasterController::class, 'store'])
        ->name('ingredient.store')->middleware('sentinel.permission:ingredient.create');

    Route::get('/{ingredient_id}/show', [IngredientMasterController::class, 'show'])
        ->name('ingredient.show')->middleware('sentinel.permission:ingredient.show');

    Route::get('/{ingredient_id}/edit', [IngredientMasterController::class, 'edit'])
        ->name('ingredient.edit')->middleware('sentinel.permission:ingredient.edit');

    Route::put('/{ingredient_id}', [IngredientMasterController::class, 'update'])
        ->name('ingredient.update')->middleware('sentinel.permission:ingredient.edit');

    Route::delete('/{ingredient_id}', [IngredientMasterController::class, 'destroy'])
        ->name('ingredient.destroy')->middleware('sentinel.permission:ingredient.destroy');

    Route::get('/ajax/data', [IngredientMasterController::class, 'datatable'])
        ->name('ingredient.ajax.data')->middleware('sentinel.permission:ingredient.show');

    Route::get('/ajax/select2', [IngredientMasterController::class, 'select2'])
        ->name('ingredient.ajax.select2');
});

Route::group([
    'middleware' => [
        'prevent.back.history'
    ],
    'prefix' => 'recipe',
], function () {
    Route::get('', [ProductRecipeController::class, 'index'])
        ->name('recipe.index')->middleware('sentinel.permission:recipe.show');

    Route::get('/create', [ProductRecipeController::class, 'create'])
        ->name('recipe.create')->middleware('sentinel.permission:recipe.create');

    Route::post('', [ProductRecipeController::class, 'store'])
        ->name('recipe.store')->middleware('sentinel.permission:recipe.create');

    Route::get('/{recipe_id}/show', [ProductRecipeController::class, 'show'])
        ->name('recipe.show')->middleware('sentinel.permission:recipe.show');

    Route::get('/{product_id}/edit', [ProductRecipeController::class, 'edit'])
        ->name('recipe.edit')->middleware('sentinel.permission:recipe.edit');

    Route::put('/{recipe_id}', [ProductRecipeController::class, 'update'])
        ->name('recipe.update')->middleware('sentinel.permission:recipe.edit');

    Route::delete('/{recipe_id}', [ProductRecipeController::class, 'destroy'])
        ->name('recipe.destroy')->middleware('sentinel.permission:recipe.destroy');

    Route::get('/product/{product}', [ProductRecipeController::class, 'getByProduct'])
        ->name('recipe.by-product')->middleware('sentinel.permission:recipe.show');

    Route::get('/ajax/data', [ProductRecipeController::class, 'datatable'])
        ->name('recipe.ajax.data')->middleware('sentinel.permission:recipe.show');
});

// product
Route::group([
    'middleware' => [
        'prevent.back.history'
    ],
    'prefix'     => 'product',
], function () {
    Route::get('', [ProductController::class, 'index'])
        ->name('product.index')->middleware('sentinel.permission:product.show');

    Route::get('/create', [ProductController::class, 'create'])
        ->name('product.create')->middleware('sentinel.permission:product.create');

    Route::post('', [ProductController::class, 'store'])
        ->name('product.store')->middleware('sentinel.permission:product.create');

    Route::get('/{id}/show', [ProductController::class, 'show'])
        ->name('product.show')->middleware('sentinel.permission:product.show');

    Route::get('/{id}/edit', [ProductController::class, 'edit'])
        ->name('product.edit')->middleware('sentinel.permission:product.edit');

    Route::put('/{id}', [ProductController::class, 'update'])
        ->name('product.update')->middleware('sentinel.permission:product.edit');

    Route::delete('/{id}', [ProductController::class, 'destroy'])
        ->name('product.destroy')->middleware('sentinel.permission:product.destroy');

    Route::get('/ajax/data', [ProductController::class, 'datatable'])
        ->name('product.ajax.data')->middleware('sentinel.permission:product.show');

    Route::get('/ajax/select2', [ProductController::class, 'select2'])
        ->name('product.ajax.select2');

    Route::get('/{id}/copy', [ProductController::class, 'copy'])
        ->name('product.copy')->middleware('sentinel.permission:product.copy');
});

// transaction
Route::group([
    'middleware' => [
        'prevent.back.history'
    ],
    'prefix'     => 'transaction',
], function () {
    Route::get('', [TransactionController::class, 'index'])
        ->name('transaction.index')->middleware('sentinel.permission:transaction.show');

    Route::get('/create', [TransactionController::class, 'create'])
        ->name('transaction.create')->middleware('sentinel.permission:transaction.create');

    Route::post('', [TransactionController::class, 'store'])
        ->name('transaction.store')->middleware('sentinel.permission:transaction.create');

    Route::get('/{id}/show', [TransactionController::class, 'show'])
        ->name('transaction.show')->middleware('sentinel.permission:transaction.show');

    Route::get('/{id}/edit', [TransactionController::class, 'edit'])
        ->name('transaction.edit')->middleware('sentinel.permission:transaction.edit');

    Route::put('/{id}', [TransactionController::class, 'update'])
        ->name('transaction.update')->middleware('sentinel.permission:transaction.edit');

    Route::delete('/{id}', [TransactionController::class, 'destroy'])
        ->name('transaction.destroy')->middleware('sentinel.permission:transaction.destroy');

    Route::get('/ajax/data', [TransactionController::class, 'datatable'])
        ->name('transaction.ajax.data')->middleware('sentinel.permission:transaction.show');

    Route::get('/{id}/update-actual-ongkir-price', [TransactionController::class, 'editActualOngkirPrice'])
        ->name('transaction.edit_actual_ongkir_price')->middleware('sentinel.permission:transaction.actualongkirprice');

    Route::put('/{id}/update-actual-ongkir-price', [TransactionController::class, 'updateActualOngkirPrice'])
        ->name('transaction.update_actual_ongkir_price')->middleware('sentinel.permission:transaction.actualongkirprice');

    Route::get('/{id}/update-payment-status', [TransactionController::class, 'editPaymentStatus'])
        ->name('transaction.edit_payment_status')->middleware('sentinel.permission:transaction.paymentstatus');

    Route::put('/{id}/update-payment-status', [TransactionController::class, 'updatePaymentStatus'])
        ->name('transaction.update_payment_status')->middleware('sentinel.permission:transaction.paymentstatus');

    Route::put('/{id}/update-start-cooking', [TransactionController::class, 'updateStartCooking'])
        ->name('transaction.update_start_cooking')->middleware('sentinel.permission:transaction.startcooking');

    Route::put('/{id}/update-start-delivery', [TransactionController::class, 'updateStartDelivery'])
        ->name('transaction.update_start_delivery')->middleware('sentinel.permission:transaction.startdelivery');

    Route::get('/{id}/update-end-delivery', [TransactionController::class, 'editEndDelivery'])
        ->name('transaction.edit_end_delivery')->middleware('sentinel.permission:transaction.enddelivery');

    Route::put('/{id}/update-end-delivery', [TransactionController::class, 'updateEndDelivery'])
        ->name('transaction.update_end_delivery')->middleware('sentinel.permission:transaction.enddelivery');

    Route::get('/{id}/pdf', [TransactionController::class, 'pdf'])
        ->name('transaction.pdf')->middleware('sentinel.permission:transaction.pdf');

    Route::get('/{id}/invoice', [TransactionController::class, 'invoice'])
        ->name('transaction.invoice')->middleware('sentinel.permission:transaction.invoice');

    Route::get('/{id}/delivery-pdf', [TransactionController::class, 'deliveryPdf'])
        ->name('transaction.delivery_pdf')->middleware('sentinel.permission:transaction.deliverypdf');

    Route::put('/{id}/update-suspend', [TransactionController::class, 'updateSuspend'])
        ->name('transaction.update_suspend')->middleware('sentinel.permission:transaction.suspend');
});

// download-transaction
Route::group([
    'middleware' => [
        'prevent.back.history'
    ],
    'prefix'     => 'download-transaction',
], function () {
    Route::get('', [TransactionDownloadController::class, 'index'])
        ->name('transaction_download.index')->middleware('sentinel.permission:transaction_download.download');

    Route::post('', [TransactionDownloadController::class, 'download'])
        ->name('transaction_download.download')->middleware('sentinel.permission:transaction_download.download');

    Route::post('/recipe', [TransactionDownloadController::class, 'downloadRecipe'])
        ->name('transaction_download.download_recipe')->middleware('sentinel.permission:transaction_download.download');
});

// log
Route::group([
    'middleware' => [
        'prevent.back.history'
    ],
    'prefix'     => 'laravel-log',
], function () {
    Route::get('', [LogViewerController::class, "index"])->middleware('sentinel.permission:log.show');
});

// import
// Route::group([
//     'middleware' => [
//         'prevent.back.history'
//     ],
//     'prefix'     => 'import',
// ], function () {
//     Route::get('', [ImportController::class, 'index'])
//         ->name('import.index')->middleware('sentinel.permission:import.show');
// });