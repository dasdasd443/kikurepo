<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RenderController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;


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

Route::get('/',[RenderController::class,'dashboard'])->name('/');

Route::get('/dashboard',[RenderController::class,'dashboard'])->name('dashboard');
Route::get('/browse/{category?}',[RenderController::class,'browse'])->name('browse');
Route::get('/product_details/{product_id}',[RenderController::class,'product_details'])->name('productDetails');
Route::middleware('auth:sanctum','verified')->get('/user/my_cart',[RenderController::class,'my_cart'])->name('my_cart');

Route::middleware('auth:sanctum','verified')->get('/logout',[UserController::class,'logout'])->name('weblogout');
Route::get('/user',[UserController::class,'requestUser'])->name('user');
Route::post('/secret',[UserController::class,'checkoutPayment'])->name('checkoutPayment');
Route::post('/add_to_cart',[UserController::class,'addToCart'])->name('addtocart');
Route::put('/edit_address/{address_id}',[UserController::class,'editAddress'])->name('editAddress');
