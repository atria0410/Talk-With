<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

use App\Models\User;

class LoginController extends Controller
{
    /***********************************************************/
    /* ログインページ                                           */
    /***********************************************************/
    public function index()
    {
        return view('login.index');
    }

    /***********************************************************/
    /* ログイン処理                                             */
    /***********************************************************/
    public function login(Request $request)
    {
        // バリデーションチェック
        $validator = User::login_validation($request);

        if ($validator->fails()) {
            return redirect('/login')
                    ->withErrors($validator)
                    ->withInput();
        }
        
        // メールアドレスからユーザー情報を取得
        $user = User::where('email', $request->email)->first();

        if (!is_null($user) && Crypt::decrypt($user->password) == $request->password) {
            // パスワードが一致
            session()->put('login', true);
            session()->put('user_id', $user->id);
            session()->put('user_name', $user->name);
            session()->put('user_icon', $user->icon);

            return redirect('room');

        } else {
            // パスワードが不一致
            $msg = 'メールアドレスまたはパスワードが間違っています';
            return redirect('/login')
                    ->withErrors(['msg' => $msg])
                    ->withInput();

        }
    }

    /***********************************************************/
    /* ゲストログイン処理                                       */
    /***********************************************************/
    public function guestLogin(Request $request)
    {
        $guestUser = User::where('id', 1)->first();

        session()->put('login', true);
        session()->put('user_id', $guestUser->id);
        session()->put('user_name', $guestUser->name);
        session()->put('user_icon', $guestUser->icon);

        return redirect('room');
    }

    /***********************************************************/
    /* ログアウト処理                                           */
    /***********************************************************/
    public function logout()
    {
        session()->flush();
        return redirect('/login');
    }

    /***********************************************************/
    /* 仮パスワード送信ページ                                    */
    /***********************************************************/
    public function passwordReset()
    {
        return view('login.password_reset');
    }

    /***********************************************************/
    /* 仮パスワード送信処理                                      */
    /***********************************************************/
    public function sendMail(Request $request)
    {
        // 仮パスワードの発行
        print_r("この処理はまだ未実装です。");
        
    }
}
