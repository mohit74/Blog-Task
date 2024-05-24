<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function signUp()
    {
        return view('auth.sign-up');
    }

    public function signIn()
    {
        return view('auth.sign-in');
    }

    public function register(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users',
            'mobile' => 'required|min:7',
            'image' => 'nullable|mimes:jpeg,jpg,png',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password'
        ]);

        $data = $request->except('_token', 'image', 'password');
                  
        if($request->has('image')){
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $request->image->move(public_path('user_images'), $imageName);
            $data['image'] = $imageName;
        }
        

        $data['password'] = Hash::make($request->password);

        // Create the user
        User::create($data);

        return redirect()->route('signIn')->with('success', 'Registration Successfully');
    }

    public function login(Request $request)
    {
        // Validate the request data
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'

        ]);

        // Attempt to log in the user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Return a response
            return redirect()->route('blogs.index')->with('success', 'Login Successfully');
        } else {
            // Return a response
            return redirect()->back()->with('success', 'Invalid email or password');

        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return redirect()->route('signIn')->with('success', 'Logout Successfully');
    }
}
