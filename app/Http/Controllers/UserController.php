<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //show register/create Form
    public function create(){
        return view('users.register');
    }

    //save registered account to database
    public function store(Request $request){
        $formField = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users','email')],
            'password' => 'required|confirmed|min:6'
        ]);
        //hashing password
        $formField['password'] = bcrypt($formField['password']);

        //create user account
        $user = User::create($formField);

        //after registration, we login
        auth()->login($user);

        return redirect('/')->with('message', 'Account Successfully Created.');
    }

    //function logout
    public function logout(Request $request){
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message','You have been logged out.');

    }

    //show login form
    public function login(){
        return view('users.login');
    }

    //we login
    public function auth(Request $request){
        $formField = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);
        if(auth()->attempt($formField)){
            $request->session()->regenerate();
            return redirect('/')->with('message',"Welcome");
        }
        return back()->withErrors(['email'=> 'Invalid credentials'])->onlyInput('email');
    }
}
