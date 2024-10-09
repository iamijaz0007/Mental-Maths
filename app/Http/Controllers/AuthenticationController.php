<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Str;
use App\Models\User;
use App\Mail\ForgotPasswordMail;

class AuthenticationController extends Controller
{
    // this mehod is use to show the login page
    public function index(){


        if(!empty(Auth::check()))
        {
            if(Auth::user()->role == 1)
            {
                return to_route('admin.dashboard');
            }
            elseif(Auth::user()->role == 2)
            {
                return to_route('principal.dashboard');
            }
            elseif(Auth::user()->role == 3)
            {
                return to_route('student.dashboard');
            }
            elseif(Auth::user()->role == 4)
            {
                return to_route('parent.dashboard');
            }
        }

        return view('login');
    }

    // register
    public function register()
    {
        return view('register');
    }

    public function registerSave(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:1,2,4'
        ]);

        $user = new User();
        $user->role = $request->role;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();

        return to_route('login');

    }


    // this method is use to authenticate the user
    public function authenticate(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->passes()){
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))){

                $admin = Auth::user();

                //check the user role
                if($admin->role == 1){
                    return redirect()->route('admin.dashboard');
                }
                else if($admin->role == 2){
                    return redirect()->route('principal.dashboard');

                }else if($admin->role == 3){
                    return redirect()->route('student.dashboard');

                }else if($admin->role == 4){
                    return redirect()->route('parent.dashboard');

                }
                else{
                    $admin = Auth::logout();
                    return redirect()->route('login')->with('error', 'U r not authorized to admin panel');

                }

            }else{
                return redirect()->route('login')->with('error', 'email or password is incorrect');
            }
        }else{
            return redirect()->route('login')->withErrors($validator)->withInput($request->only('email'));
        }

    }

    public function forgotpassword()
    {
        return view('forgotpassword');
    }

    public function Postforgotpassword(Request $request)
    {
        // Validate the provided email
        $request->validate([
            'email' => 'required|email', // This line validates the email input
        ]);
    
        $user = User::getEmailSingle($request->email);
        if(!empty($user))
        {
            $user->remember_token = Str::random(10);
            $user->save();
            Mail::to($user->email)->send(new ForgotPasswordMail($user));
            return redirect()->back()->with('success', 'Check your email and reset your password');
        }
        else
        {
            return redirect()->back()->with('error', 'Email not found');
        }

    }


    public function logout()
    {
        Auth::logout(); // Log out the user
        return redirect()->route('login'); // Redirect to login page
    }



}
