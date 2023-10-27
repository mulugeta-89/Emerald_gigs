<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // to show the register page/form
    public function create(){
        return view("users.register");
    }

    //to store the user
    public function store(Request $request){
        // used to validate form fields
        $formFields = $request->validate([
            "name" => ["required", "min:3"],
            "email" => ["required", "email", Rule::unique("users", "email")],
            "password" => "required|confirmed|min:6"
        ]);
        // used to hash the password
        $formFields["password"] = bcrypt($formFields["password"]);
        //used to create the user from the formfields
        $user = User::create($formFields);
        //used to login the user
        auth()->login($user);

        return redirect("/")->with("message", "User created and logged in");
    }
    //to logout user
    public function logout(Request $request){
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect("/")->with("message", "user logged out succesfully!");
    }
    // to show the login form
    public function login(){
        return view("users.login");
    }
    public function authenticate(Request $request){
        $formFields = $request->validate([
            "email" => ["required", "email"],
            "password" => "required"
        ]);
        // happen when push the sign in button
        if(auth()->attempt($formFields)){
            $request->session()->regenerate();
            return redirect("/")->with("message", "User logged in!");
        }
        return back()->withErrors(["email"=>"invalid credentials"])->onlyInput("email");
    }
    
}
