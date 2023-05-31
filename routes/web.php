<?php

use App\Http\Controllers\demoController;
use App\Http\Controllers\formController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\sumController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

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

// Route::get('/demo', [sumController::class, 'index']);

//thực hiện đường dẫn để chạy controller

// Route::get('/Form',[formController::class, 'index']);
// Route::post('/Form', [formController::class, 'displayInfo']);

Route :: get('/master', [PageController:: class, 'getIndex']);

Route :: get('database', function(){
    Schema:: create('loaisanpham', function($table){
        $table->increments('id');
        $table->string('ten',200);
    });
    echo "Da tao thanh cong";
});