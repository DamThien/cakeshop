<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
 
class demoController extends Controller
{
    
    public function functionName() {
        $title= "Thầy Đình";
        $dess = "Dạy IT";
        $price = 5000;
        $arr = ['title'=> $title,'dess'=>$dess,'price'=> $price];
        return view('test') -> with('student',$arr);
    //    return view('test') ->with(['title'=>$title, 'dess'=> $dess, 'price' => $price]);
    }
}
