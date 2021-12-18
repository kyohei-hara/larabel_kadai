<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLoginForm;
use App\Models\OnlineMember;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers;

    public function login(StoreLoginForm $request)
    {
      $message = '';
      if ($request->isMethod('POST')) {
        $member_no = $request->input('member_no');
        $password = $request->input('pass');
        if ($member=OnlineMember::where(['MEMBER_NO' => $member_no,'PASSWORD' => $password, 'DELETE_FLG' => 0])->first()) {
          Auth::login($member);
          return route('home');
        } else {
          $message = 'ログインに失敗しました。';
        }
      }
      return view('auth/login',[
        'message' => $message
      ]);
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}