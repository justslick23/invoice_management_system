<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;

use App\Http\Controllers\CustomerHistoryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceHistoryController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\QuoteHistoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductListController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
		Route::get('icons', ['as' => 'pages.icons', 'uses' => 'App\Http\Controllers\PageController@icons']);
		Route::get('maps', ['as' => 'pages.maps', 'uses' => 'App\Http\Controllers\PageController@maps']);
		Route::get('notifications', ['as' => 'pages.notifications', 'uses' => 'App\Http\Controllers\PageController@notifications']);
		Route::get('rtl', ['as' => 'pages.rtl', 'uses' => 'App\Http\Controllers\PageController@rtl']);
		Route::get('tables', ['as' => 'pages.tables', 'uses' => 'App\Http\Controllers\PageController@tables']);
		Route::get('typography', ['as' => 'pages.typography', 'uses' => 'App\Http\Controllers\PageController@typography']);
		Route::get('upgrade', ['as' => 'pages.upgrade', 'uses' => 'App\Http\Controllers\PageController@upgrade']);


		Route::get('/customers', [CustomerController::class, 'index'])->name('customer.index');

			// Create a new customer
			Route::get('/customers/create', [CustomerController::class, 'create'])->name('customer.create');
			Route::post('/customers', [CustomerController::class, 'store'])->name('customers.index');
			Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
			Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');

			Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');

			// Routes for Invoices
Route::get('/invoices/create', [InvoiceController::class, 'create'])->name('invoice.create');
Route::post('/invoices', [InvoiceController::class, 'store'])->name('invoice.store');
Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoice.index');
Route::get('/invoice/edit/{id}',  [InvoiceController::class, 'edit'])->name('invoice.edit');
Route::get('/invoice/download-pdf/{id}', [InvoiceController::class, 'downloadPDF'])->name('invoice.download');
Route::delete('/invoice/destroy/{id}', 'InvoiceController@destroy')->name('invoice.destroy');
Route::put('/invoice/update/{id}',  [InvoiceController::class, 'update'])->name('invoice.update');
Route::post('/invoices/{invoice}/record-payment', [InvoiceController::class, 'recordPayment'])->name('invoice.recordPayment');
Route::get('/send-invoice-email/{invoiceId}/{recipientEmail}', [InvoiceController::class, 'sendInvoiceEmail'])->name('send.invoice.email');


// Routes for Quotations
Route::get('/quotations/create', [QuoteController::class, 'create'])->name('quote.create');
Route::post('/quotations', [QuoteController::class, 'store'])->name('quote.store');
Route::get('/quotations', [QuoteController::class, 'index'])->name('quote.index');

Route::get('/quote-history', [QuoteHistoryController::class, 'index'])->name('quote.history');

// Routes for Products
Route::get('/products/create', [ProductController::class, 'create'])->name('product.create');
Route::post('/products', [ProductController::class, 'store'])->name('product.store');
Route::get('/products', [ProductController::class, 'index'])->name('product.index');

Route::get('/product-list', [ProductListController::class, 'index'])->name('product.list');
});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

