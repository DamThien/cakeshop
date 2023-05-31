<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Slide;

class PageController extends Controller
{
    //
    public function getIndex(){

        $slide = Slide::all();
        $new_product = Product::where('new',1)->paginate(8);
        $spkhuyenmai = Product::where('promotion_price', '<>', 0)->paginate(4);		

        return View('page.trangchu',compact('slide','new_product','spkhuyenmai'));
    }
}
