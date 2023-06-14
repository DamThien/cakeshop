<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIcontroller;
use App\Http\Controllers\T1Controller;		
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// create api
Route::get('/get-product', [APIcontroller::class, 'getProducts']);
Route::get('/get-product/{id}', [APIcontroller::class, 'getOneProduct']);
Route::post('/add-product', [APIcontroller::class, 'addProduct']);
Route::delete('/delete-product/{id}', [APIcontroller::class, 'deleteProduct']);
Route::put('/edit-product/{id}', [APIcontroller::class, 'editProduct']);

Route::post('/upload-image', [APIcontroller::class, 'uploadImage']);
// create T1 API
Route::get('/get-T1', [T1Controller::class, 'getT1s']);

Route::get('/get-T1/{id}', [T1Controller::class, 'getOneT1']);
Route::post('/add-T1', [T1Controller::class,'addT1']);
Route::delete('/delete-T1/{id}', [T1Controller::class, 'deleteT1']);
Route::put('/edit-T1/{id}', [T1Controller::class, 'editT1']);

Route::post('/upload-t1-image', [T1Controller::class, 'uploadImage']);