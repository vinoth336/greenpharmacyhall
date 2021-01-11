<?php

//use Illuminate\Support\Facades\Auth;
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

Route::get('/', 'SiteController@index')->name('home');
Route::get('/service/{slug?}', 'SiteController@services')->name('service');
Route::get('/portfolio/', 'SiteController@portfolio')->name('portfolio');
Route::get('/faqs/', 'SiteController@faqs')->name('site_faqs');
Route::post('enquiry', 'SaveEnquiryController@store')->name('enquiry.store');
Route::get('/product/summary/{productId}', 'SiteController@viewProductSummary')->name('view_product_summary');
Route::get('/search', 'ProductSearchController@index')->name('public.product_list');



Route::get('/registration', 'UserRegistrationController@index')->name('public.registration');
Route::post('/registration', 'UserRegistrationController@create');
Route::get('/register/success/{id}', 'UserRegistrationController@registerationSuccess')->name('public.registration_success');
Route::get('/email/verify/{hash}', 'UserRegistrationController@verifyEmail')->name('public.verify_email');
Route::post('/email/resend', 'UserRegistrationController@resendEmailVerification')
         ->middleware('throttle:5,1')
         ->name('public.resend_email_verify');

Route::get('/login', 'UserLoginController@showLoginForm')->name('public.login');
Route::post('/login', 'UserLoginController@login');
Route::post('/logout', 'UserLoginController@logout')->name('public.logout');
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

Route::group(['middleware' => 'auth:web'], function() {
    Route::get('dashboard', 'UserController@dashboard')->name('public.dashboard');
    Route::put('profile', 'UserController@update')->name('public.update_profile');
    Route::get('pharma_create_order', 'PharmaOrderController@index')->name('public.pharma_purchase_order');
    Route::post('pharma_create_order', 'PharmaOrderController@create');
    Route::get('pharma_orders', 'PharmaOrderController@orderList')->name('public.pharma_order_list');
    Route::delete('pharma_order_delete/{order}', 'PharmaOrderController@deleteOrder')->name('public.pharma_order_delete');

});

Route::group(['prefix' => 'admin'], function () {
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');


    Route::group(['middleware' => 'auth:admin_users'], function(){

        Route::get('dashboard', 'HomeController@index')->name('admin.dashboard');
        Route::put('faqs/update_sequence', 'FaqsController@updateSequence')->name('faqs.update_sequence');
        Route::resource('faqs', 'FaqsController');
        Route::put('category_types/update_sequence', 'CategoryTypeController@updateSequence')->name('category_types.update_sequence');
        Route::resource('category_types', 'CategoryTypeController');
        Route::put('brands/update_sequence', 'BrandController@updateSequence')->name('brands.update_sequence');
        Route::resource('brands', 'BrandController');
        Route::put('services/update_sequence', 'ServicesController@updateSequence')->name('faqs.update_sequence');
        Route::resource('services', 'ServicesController');
        Route::get('site_information', 'SiteInformationController@index')->name('site_information.index');
        Route::post('site_information', 'SiteInformationController@store')->name('site_information.store');
        Route::put('slider/update_sequence', 'SliderController@updateSequence')->name('slider.update_sequence');
        Route::resource('slider', 'SliderController');
        Route::resource('banner', 'BannerController');
        Route::resource('enquiries', 'EnquiriesController')->except('store');
        Route::resource('testimonials', 'TestimonialController');
        Route::put('portfolio/update_sequence', 'PortfolioController@updateSequence')->name('portfolio.update_sequence');
        Route::resource('portfolio', 'PortfolioController');

        Route::put('portfolio_images/update_sequence', 'PortfolioImageController@updateSequence')->name('portfolio_images.update_sequence');
        Route::delete('portfolio_images/{portfolio_image}', 'PortfolioImageController@destroy')->name('portfolio_image.delete');

        Route::resource('pharma_orders', 'PharmaOrderAdminController')->except(['store', 'create', 'edit']);


        Route::group(['middleware' => 'auth'], function () {
            Route::resource('user', 'UserController', ['except' => ['show']]);
            Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
            Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
            Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
        });

    });

});

