<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
// use Hash;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Contracts\Session\Session;


class AuthController extends Controller
{

    public function index()
    {
        return view('auth.login');
    }


    public function registration()
    {
        return view('auth.register');
    }


    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            return redirect()->intended('dashboard')
                        ->withSuccess('You have Successfully logged in');
        }

        return redirect("/")->withSuccess('Sorry! You have entered invalid credentials');
    }


    public function postRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $data = $request->all();
        $check = $this->create($data);

        return redirect("/")->withSuccess('Great! please login.');
    }


    public function dashboard()
    {
        if(Auth::check()){
            return view("dashboard",[
                'tasks' => Todo::where('user_id','=',Auth::user()->id)->get()
            ]);
        }

        return redirect("/")->withSuccess('Opps! You do not have access');
    }


    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => bcrypt($data['password']),

      ]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function logout() {
        Session::flush();
        Auth::logout();

        return Redirect('/');
    }
}
