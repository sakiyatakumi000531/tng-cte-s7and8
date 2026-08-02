<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\RegisterRequest;
use Illuminate\Auth\Events\Registered;

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

    /*
    |--------------------------------------------------------------------------
    | 処理の流れ
    |--------------------------------------------------------------------------
    | 1. validator() または register() でバリデーションチェック
    | 2. エラーがなければ create() でユーザーを保存
    | 3. Auth::login($user) で自動ログイン
    | 4. $redirectTo で設定しているURLへリダイレクト
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/products';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest');
    }

    /**
     * 💡 引数を「Request」から「RegisterRequest」に変更してメソッドをオーバーライド
     */
    public function register(RegisterRequest $request) {
        // ここに到達した時点で、バリデーションは自動的に通過している（失敗時は自動リダイレクト）

        // ユーザーの作成
        $user = $this->create($request->validated());

        // 登録イベントの発火
        event(new Registered($user));

        // 自動ログイン
        $this->guard()->login($user);

        // リダイレクト処理
        return $request->wantsJson()
                    ? response()->json([], 201)
                    : redirect($this->redirectPath());
    }

    /*
    register()をオーバーライドし、Form Request バリデーションする方法を採用するので使わない

        protected function validator(array $data) {
            return Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
        }
    */

    /**
     * ユーザー保存ロジック（$dataにはバリデーション済みのデータが入る）
     */
    protected function create(array $data) {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
