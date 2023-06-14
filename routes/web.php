<?php

// use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
//use Illuminate\Support\Facades\Schema;

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

// Route::get('/', function () {
//     return view('welcome');
// });


// trang cắt layout
// Route::get('/', function () {return view('master');}) -> name('index');
// Route::get('/home', function () {return view('page.trangchu');}) -> name('home');

// Route::get('loai-san-pham',[				
// 	'as'=>'loaisanpham',			
// 	'uses'=>'PageController@getLoaiSp'			
// 	]);			

//   Route::get('chi-tiet-san-pham',[				
//     'as'=>'chitietsanpham',			
//     'uses'=>'PageController@geChitiet'			
//     ]);	
    

    // trang web bánh mi
    Route::get('/', function(){
        return redirect('/trangchu');
    });

    Route::get('/trangchu', [App\Http\Controllers\PageController::class,'getIndex']);
    Route::get('/type/{id}', [App\Http\Controllers\PageController::class,'getLoaiSp']);
    Route::get('/detail/{id}', [App\Http\Controllers\PageController::class,'getDetail']);

    Route::get('/contact', [App\Http\Controllers\PageController::class,'getContact']);
    Route::get('/about', [App\Http\Controllers\PageController::class,'getAbout']);




    //Admin
    Route::get('/admin', [App\Http\Controllers\PageController::class, 'getIndexAdmin']);											
    
    //Cấu hình Route  để chạy giao diện thêm sản phẩm					
    Route::get('/admin-add-form', [App\Http\Controllers\PageController::class, 'getAdminAdd'])->name('add-product');	
    
    //Xây dựng Route để thưc hiện Post dữ liệu					
    Route::post('/admin-add-form', [App\Http\Controllers\PageController::class, 'postAdminAdd']);	
    
    //Xây dựng Route để thực hiện Sữa giao diện cho trang sửa
    Route::get('/admin-edit-form/{id}', [App\Http\Controllers\PageController::class, 'getAdminEdit'])->name('getAdminEdit');	
    
    // Xây dựng Route để thực hiện Sữa giao diện cho trang sửa
    Route::post('/admin-edit', [App\Http\Controllers\PageController::class, 'postAdminEdit']);	
    
    // Xây dựng Route để thực hiện xóa sản phẩm
    Route::get('/admin-delete{id}', [App\Http\Controllers\PageController::class, 'postAdminDelete'])->name('postAdminDelete');


    Route::get('/admin-export', [App\Http\Controllers\PageController::class, 'exportController@export'])->name('export');




    Route::get('loai-san-pham/{type}',[				
        'as'=>'loaisanpham',			
        'uses'=>'PageController@getLoaiSp'		
        
        ]);
    Route::get('/register', function () {
        return view('users.register');
    });

    Route::post("/register", [UserController::class, "Register"]);
    Route::get('/login', function () {
        return view('users.login');
    });
    Route::post("/login", [UserController::class, "Login"]);
    Route::get("/logout", [UserController::class, "Logout"]);

//     Route::get('/database', function () {
//       Schema::create('loaianpham', function ($table) {
//           $table->increments('id');
//           $table->string('ten', 2000);
//       });
  
//       echo "Đã thực hiện tạo bảng thành công!";
//   });
  

// Route::get('/signup',"signupController@index");
// Route::post('/signup',"signupController@displayInfor");

// Route::get('/master',"pageController@getIndex");