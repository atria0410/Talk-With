<?php

namespace App\Http\Middleware;

use Closure;

class AccessAuth
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
        // アクセス権限がない場合前の画面にリダイレクト
        if(session('user_id') != $request->route()->parameter('user_id')){
            // メッセージを表示
            echo "<script>alert('アクセス権限がありません。リダイレクトします。')</script>;";

            $previous_url = parse_url(url()->previous(), PHP_URL_PATH);
			return redirect($previous_url);
        }

        return $next($request);
    }
}
