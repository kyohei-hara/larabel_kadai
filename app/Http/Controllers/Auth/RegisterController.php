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
        $formItems=['name', 'password','age','sex','zip','address','tell'];
        $this->validator($request->all())->validate();

        $input = $request->only($formItems);
        $request->session()->put("form_input", $input);
        return redirect()->action('Auth\RegisterController@confirm');
    }

    /**
     * 登録処理
     *
     */
    public function register(Request $request)
    {
        $input = $request->session()->get("form_input");

        // 戻るボタン
        if ($request->has("back")) {
            return redirect()->action('Auth\RegisterController@showRegistrationForm')
                ->withInput($input);
        }

        //セッションに値が無い時はフォームに戻る
        if (!$input) {
            return redirect()->action('Auth\RegisterController@showRegistrationForm');
        }

        //登録
        event(new Registered($user = $this->create($request->all())));

        //セッションを空にする
        $request->session()->forget("form_input");
        // 登録データーでログイン
        Auth::login($user);
        return view('test.test');
        // return $this->registered($request, $user)
        //     ?  : redirect($this->redirectPath());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        //MEMBER_NOの最大の値を取得
        $newMemberNo = DB::table('online_member')->get('MEMBER_NO')->sortByDesc('MEMBER_NO')->first();
        return OnlineMember::create([
            'MEMBER_NO' => $newMemberNo->MEMBER_NO + 1,
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
     * 会員登録入力フォーム出力
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm(Request $request)
    {
        //セッションを空にする
        $request->session()->forget("form_input");
        return view('auth.register.register');
    }

    /*
     * 確認画面出力
     */
    public function confirm(Request $request)
    {
        //セッションから値を取り出す
        $input = $request->session()->get("form_input");

        //セッションに値が無い時はフォームに戻る
        if (!$input) {
            return redirect()->action("Auth\RegisterController");
        }

        return view('auth.register.confirm', ["input" => $input]);
    }

    /*
     * 完了画面出力
     */
    public function complete()
    {
        return view('auth.register.complete');
    }
}