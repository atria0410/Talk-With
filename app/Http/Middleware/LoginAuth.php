<?php

namespace App\Http\Middleware;

use Closure;

class LoginAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // アクセス元URLを取得
        $access_url = parse_url(url()->current(), PHP_URL_PATH);
        $urls = [
            '/login',
            '/guestlogin',
            '/logout',
            '/password_reset',
            '/user/new',
        ];

        // ログインしていなければログイン画面にリダイレクト
        if(session('login') == false && !in_array($access_url, $urls)){
            echo "<script>alert('ログインしてください。')</script>;";
			return redirect('/login');
        }

        // ログイン済みでログイン画面などに遷移した場合
        if(session('login') == true && in_array($access_url, $urls)) {
            echo "<script>alert('既にログインしています。')</script>;";
            $previous_url = parse_url(url()->previous(), PHP_URL_PATH);
            
            if ($previous_url != $access_url) {
			    return redirect($previous_url);
            } else {
                // 無限ループ対策
                return redirect('/');
            }
        }
        
        return $next($request);
    }
}
