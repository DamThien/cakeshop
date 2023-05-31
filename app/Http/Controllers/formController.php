<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignupRequest;
use Illuminate\Http\Request;

class formController extends Controller
{
    public function index(){
        return view('Form');
    }
    public function displayInfo(SignupRequest $Request){
        $user=[
            'name'=> $name =$Request ->input('name'),
            'age'=> $age =$Request ->input('age'),
            'date' => $date = $Request->input('date'),
            'phone' => $phone = $Request->input('phone'),
            'web' => $web = $Request->input('web'),
            'adress' => $adress = $Request->input('adress')

        ];
            return view('Form') ->with('user',$user);

    }
}
