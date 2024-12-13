<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;


use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
   

    protected function authenticated(Request $request, $user)
    {
        if ($user->id == 4||$user->id ==5) {
            session()->flash('toast', 'Welcome back, ' . $user->name . '!');
            return redirect()->route('admin'); 
        }
        session()->flash('toast', 'Welcome back, ' . $user->name . '!');
        return redirect('/');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
