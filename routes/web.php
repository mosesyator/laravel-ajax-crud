<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

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

Route::get('/customers', 'App\Http\Controllers\CustomersController@index')->name('contact.index');
Route::get('/customer/{id}', 'App\Http\Controllers\CustomersController@getCustomerById');
Route::post('/add-customers', 'App\Http\Controllers\CustomersController@addCustomer')->name('addCustomer');
Route::put('/update-customers', 'App\Http\Controllers\CustomersController@updateCustomer')->name('updateCustomer');
Route::delete('/deleteCustomer/{id}', 'App\Http\Controllers\CustomersController@deleteCustomer')->name('deleteCustomer');

//Route::get('/customers',[CustomersController::class,'index']);
//Route::get('/customer/{id}',[CustomersController::class,'getCustomerById']);
//Route::post('/add-customers',[CustomersController::class,'addCustomer'])->name('addCustomer');
//Route::put('/update-customers',[CustomersController::class,'updateCustomer'])->name('updateCustomer');
//Route::delete('/deleteCustomer/{id}',[CustomersController::class,'deleteCustomer'])->name('deleteCustomer');

Route::resource('students',StudentController::class);