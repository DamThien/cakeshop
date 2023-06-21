<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Symfony\Component\Console\Input\Input;
use App\Models\User;
use Validator;
use App\Http\Requests;
// namespace App\Http\Controllers;

// use Illuminate\Http\Request;

class UserController extends Controller
{
    public function Login(request $request)
    {
        $login = [
            'email' => $request->input('email'),
            'password' => $request->input('pw')
        ];
        if (Auth::attempt($login)) {
            $user = Auth::user();
            Session::put('user', $user);
            echo '<script>alert("Đăng nhập thành công.");window.location.assign("trangchu");</script>';
        } else {
            echo '<script>alert("Đăng nhập thất bại.");window.location.assign("login");</script>';
        }
    }
    // public function customLogin(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required',
    //         'password' => 'required',
    //     ]);

    //     $credentials = $request->only('email', 'password');
    //     if (Auth::attempt($credentials)) {
    //         return redirect()->intended('dashboard')
    //         ->withSuccess('Signed in');
    //     }

    //     return redirect("login")->withSuccess('Login details are not valid');
    // }

    public function Logout()
    {
        Session::forget('user');
        Session::forget('cart');
        return redirect('trangchu');
    }

    public function Register(Request $request)
    {
        $input = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password'
        ]);

        $input['password'] = bcrypt($input['password']); // Mã hóa mật khẩu

        User::create($input);

        echo '<script>alert("Đăng ký thành công. Vui lòng đăng nhập");window.location.assign("login");</script>';
    }
}
