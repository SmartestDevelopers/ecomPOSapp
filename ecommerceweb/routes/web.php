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

// Public Routes
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index'); // Laravel auth redirect
Route::get('/about', 'HomeController@about')->name('about');

// Product Routes
Route::get('/products', 'ProductController@index')->name('products.index');
Route::get('/product/{slug}', 'ProductController@show')->name('product.show');

// Category Routes
Route::get('/categories', 'CategoryController@index')->name('categories.index');
Route::get('/category/{slug}', 'CategoryController@show')->name('category.show');

// Search Routes
Route::get('/search', 'SearchController@index')->name('search');
Route::get('/api/search/autocomplete', 'SearchController@autocomplete')->name('search.autocomplete');

// Contact Routes
Route::get('/contact', 'ContactController@index')->name('contact.index');
Route::post('/contact', 'ContactController@store')->name('contact.store');

// SEO Routes
Route::get('/sitemap.xml', 'SeoController@sitemap')->name('sitemap');
Route::get('/robots.txt', 'SeoController@robots')->name('robots');

// Authentication Routes
Auth::routes();

// Authenticated User Routes
Route::middleware(['auth'])->group(function () {
    // Shopping Cart Routes
    Route::get('/cart', 'CartController@index')->name('cart.index');
    Route::post('/cart/add/{id}', 'CartController@add')->name('cart.add');
    Route::patch('/cart/update/{id}', 'CartController@update')->name('cart.update');
    Route::delete('/cart/remove/{id}', 'CartController@remove')->name('cart.remove');
    Route::delete('/cart/clear', 'CartController@clear')->name('cart.clear');
    
    // Checkout Routes
    Route::get('/checkout', 'OrderController@checkout')->name('checkout');
    Route::post('/checkout', 'OrderController@processCheckout')->name('checkout.process');
    
    // Order Routes
    Route::get('/orders', 'OrderController@index')->name('orders.index');
    Route::get('/orders/{id}', 'OrderController@show')->name('orders.show');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', 'Admin\AdminController@index')->name('admin.dashboard');
    Route::get('/dashboard', 'Admin\AdminController@index')->name('admin.dash');
    
    // Product Management
    Route::resource('products', 'Admin\AdminProductController')->names([
        'index' => 'admin.products.index',
        'create' => 'admin.products.create',
        'store' => 'admin.products.store',
        'show' => 'admin.products.show',
        'edit' => 'admin.products.edit',
        'update' => 'admin.products.update',
        'destroy' => 'admin.products.destroy',
    ]);
    
    // Category Management
    Route::resource('categories', 'Admin\AdminCategoryController')->names([
        'index' => 'admin.categories.index',
        'create' => 'admin.categories.create',
        'store' => 'admin.categories.store',
        'show' => 'admin.categories.show',
        'edit' => 'admin.categories.edit',
        'update' => 'admin.categories.update',
        'destroy' => 'admin.categories.destroy',
    ]);
    
    // Order Management
    Route::get('orders', 'Admin\AdminOrderController@index')->name('admin.orders.index');
    Route::get('orders/{id}', 'Admin\AdminOrderController@show')->name('admin.orders.show');
    Route::get('orders/{id}/edit', 'Admin\AdminOrderController@edit')->name('admin.orders.edit');
    Route::put('orders/{id}', 'Admin\AdminOrderController@update')->name('admin.orders.update');
    Route::patch('orders/{id}/status', 'Admin\AdminOrderController@updateStatus')->name('admin.orders.updateStatus');
    
    // Customer Management
    Route::get('customers', 'Admin\AdminController@customers')->name('admin.customers');
    Route::get('customers/{id}/orders', 'Admin\AdminController@customerOrders')->name('admin.customers.orders');
    
    // User Management
    Route::get('users', 'Admin\AdminController@users')->name('admin.users');
    Route::patch('users/{id}/role', 'Admin\AdminController@updateUserRole')->name('admin.users.updateRole');
    
    // Contact Messages
    Route::get('messages', 'Admin\AdminController@messages')->name('admin.messages');
});
