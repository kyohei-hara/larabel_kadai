<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use App\Models\OnlineMember;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use DateTime;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'max:20'],
            'password' => ['required', 'max:8', 'same:password_confirm'],
            'password_confirm' => ['required', 'max:8', 'same:password'],
            'age' => ['required', 'numeric', 'positive'],
            'zip' => ['zip'],
            'address' => ['max:50'],
            'tell' => ['num_hyphen','max:20'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function post(Request $request)
    {
        $formItems=['name', 'password', 'password_confirm' ,'age','sex','zip','address','tell'];
        $this->validator($request->all())->validate();

        $input = $request->only($formItems);
        $request->session()->put("form_input", $input);
        return redirect()->action('Auth\RegisterController@confirm');
    }

    /**
     * ????????????
     *
     */
    public function register(Request $request)
    {
        $input = $request->session()->get("form_input");

        // ???????????????
        if ($request->has("back")) {
            return redirect()->action('Auth\RegisterController@showRegistrationForm')
                ->withInput($input);
        }

        //?????????????????????????????????????????????????????????
        if (!$input) {
            return redirect()->action('Auth\RegisterController@showRegistrationForm');
        }

        //??????
        event(new Registered($user = $this->create($request->all())));

        //??????????????????????????????
        $request->session()->forget("form_input");
        // ?????????????????????????????????
        Auth::login($user);
        return $this->complete(true);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $memberNo = 0;
        //MEMBER_NO????????????????????????
        $newMemberNo = DB::table('online_member')->get('MEMBER_NO')->sortByDesc('MEMBER_NO')->first();
        if($newMemberNo != null) {
            $memberNo = $newMemberNo->MEMBER_NO;
        }
        return OnlineMember::create([
            'MEMBER_NO' => $memberNo + 1,
            'NAME' => $data['name'],
            'PASSWORD' => $data['password'],
            'AGE' => $data['age'],
            'SEX' => $data['sex'],
            'TEL' => $data['tell'],
            'ZIP' => $data['zip'],
            'ADDRESS' => $data['address'],
            'REGISTER_DATE' => new DateTime(),
        ]);
    }

    /**
     * ????????????????????????????????????
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm(Request $request)
    {
        //??????????????????????????????
        $request->session()->forget("form_input");
        return view('auth.register.register');
    }

    /*
     * ??????????????????
     */
    public function confirm(Request $request)
    {
        //???????????????????????????????????????
        $input = $request->session()->get("form_input");

        //?????????????????????????????????????????????????????????
        if (!$input) {
            return route("login");
        }

        return view('auth.register.confirm', ["input" => $input]);
    }

    /*
     * ??????????????????
     */
    public function complete($isRegister = false)
    {
        if($isRegister) return view('auth.register.complete');
        return route('home');
    }
}