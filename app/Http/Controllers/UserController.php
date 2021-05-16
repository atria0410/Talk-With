<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use InterventionImage;
use App\Models\User;
use App\Models\Follow;
use App\Models\Room;

class UserController extends Controller
{
    /***********************************************************/
    /* 権限チェック                                             */
    /***********************************************************/
    public function permissionCheack($user_id) {
        // アクセス権限がない場合前の画面にリダイレクト
        if(session('user_id') != $user_id){
            // メッセージを表示
            echo "<script>alert('アクセス権限がありません。リダイレクトします。')</script>;";
            return false;
        }
        return true;
    }

    /***********************************************************/
    /* ユーザー閲覧ページ                                        */
    /***********************************************************/
    public function show($user_id)
    {
        // ユーザー情報取得
        $user = User::find($user_id);

        // ユーザーが存在しない、またはゲストユーザーが指定された場合はリダイレクト
        if (is_null($user) || $user_id == 1) {
            echo "<script>alert('ユーザーが存在しません。')</script>;";
            $previous_url = parse_url(url()->previous(), PHP_URL_PATH);
			return redirect($previous_url);
        }

        // フォロー状態を取得
        $follow = Follow::where('user_id', session('user_id'))
                        ->where('follow_id', $user_id)
                        ->first();

        $followed = (!is_null($follow)) ? true : false;

        $params = [
            'user' => $user,
            'followed' => $followed,
        ];

        return view('user.show', $params);
    }

    /***********************************************************/
    /* ユーザー登録（新規登録）ページ                             */
    /***********************************************************/
    public function new()
    {
        return view('user.new');
    }
    
    /***********************************************************/
    /* ユーザー登録処理                                         */
    /***********************************************************/
    public function create(Request $request)
    {
        // バリデーションチェック
        $validator = User::signup_validation($request);
        if ($validator->fails()) {
            return redirect('/user/new')
                    ->withErrors($validator)
                    ->withInput();
        }

        // DBに保存
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Crypt::encrypt($request->password);
        $user->icon = 'icon/default.jpg';
        $user->save();

        // セッションを保持
        session()->put('login', true);
        session()->put('user_id', $user->id);
        session()->put('user_name', $user->name);
        session()->put('user_icon', $user->icon);

        return redirect('room')
            ->with('flash_message', 'ようこそ ' . $user->name . ' さん');
    }

    /***********************************************************/
    /* ユーザー編集ページ                                        */
    /***********************************************************/
    public function edit($user_id)
    {
        // アクセス権限チェック
        $access = $this->permissionCheack($user_id);
        if (!$access) {
            $previous_url = parse_url(url()->previous(), PHP_URL_PATH);
            return redirect($previous_url);
        }

        // ユーザー情報を取得
        $user = User::find($user_id);

        return view('user.edit', ['user' => $user]);
    }

    /***********************************************************/
    /* ユーザー編集処理                                         */
    /***********************************************************/
    public function update(Request $request, $user_id)
    {
        // アクセス権限チェック
        $access = $this->permissionCheack($user_id);
        if (!$access) {
            $previous_url = parse_url(url()->previous(), PHP_URL_PATH);
            return redirect($previous_url);
        }
        
        // バリデーションチェック
        $validator = User::edit_validation($request, $user_id);
        if ($validator->fails()) {
            return redirect('/user/' . $user_id . '/edit')
                    ->withErrors($validator)
                    ->withInput();
        }

        // DBに保存
        $user = User::find($user_id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->comment = $request->comment;
        $user->password = Crypt::encrypt($request->password);

        // ユーザーアイコンがあれば[strage/app/public/icon]に保存
        $icon = $request->icon;
        if (!is_null($icon)) {
            $filePath = 'icon/user' . session('user_id') . '.jpg';

            $icon = InterventionImage::make($icon)
                ->encode('jpg')
                ->fit(256, 256)
                ->save(storage_path() . '/app/public/' . $filePath);

            $user->icon = $filePath;
        }

        $user->save();

        session()->put('user_name', $user->name);
        session()->put('user_icon', $user->icon);

        return redirect('/user/' . $user_id)
            ->with('flash_message', 'ユーザー情報が更新されました');
        
    }

    /***********************************************************/
    /* フォロワー取得                                           */
    /***********************************************************/
    public function getFollower($follow_id)
    {
        // フォロワー情報の取得
        $sql = <<< SQL
        SELECT
            users.id,
            users.name,
            users.icon,
            users.comment,
            CASE
                WHEN users.id IN (
                    SELECT follow_id FROM follows WHERE user_id = :user_id
                ) THEN true
                ELSE FALSE
            END AS followed
        FROM
            follows
        JOIN users ON follows.user_id = users.id
        WHERE follow_id = :follow_id
        ORDER BY follows.updated_at
        SQL;

        $params = [
            'user_id' => session('user_id'),
            'follow_id' => $follow_id,
        ];

        $follower = DB::select($sql, $params);

        $json = json_encode($follower);

        echo $json;
    }

    /***********************************************************/
    /* フォロー                                                 */
    /***********************************************************/
    public function follow(Request $request)
    {
        $follow = new Follow;

        $follow->user_id = session('user_id');
        $follow->follow_id = $request->follow_id;
        $follow->save();

        return redirect('/user/' . $request->follow_id);
    }

    /***********************************************************/
    /* フォロー解除                                             */
    /***********************************************************/
    public function unFollow(Request $request)
    {
        Follow::where('user_id', session('user_id'))
              ->where('follow_id', $request->follow_id)
              ->delete();

        return redirect('/user/' . $request->follow_id);
    }
}
