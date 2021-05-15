<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Validator;

class User extends Model
{
    protected $guarded = ['id'];

    /* サインアップ時のバリデーション */
    public static function signup_validation($request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
        ];
        $message = [
            'name.required' => '名前を入力してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスの形式に間違いがあります',
            'email.unique' => 'このメールアドレスは既に使用されています',
            'password.required' => 'パスワードを入力してください',
            'password.confirmed' => 'パスワード（確認）と異なります',
        ];
        return Validator::make($request->all(), $rules, $message);
    }

    /* ログイン時のバリデーション */
    public static function login_validation($request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];
        $message = [
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスの形式に間違いがあります',
            'password.required' => 'パスワードを入力してください',
        ];
        return Validator::make($request->all(), $rules, $message);
    }

    /* 編集時のバリデーション */
    public static function edit_validation($request, $user_id)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user_id . ',id',
            'password' => 'required|confirmed',
            'icon' => 'mimes:jpeg,gif,png',
            'comment' => 'max:30',
        ];
        $message = [
            'name.required' => '名前を入力してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスの形式に間違いがあります',
            'email.unique' => 'このメールアドレスは既に使用されています',
            'password.required' => 'パスワードを入力してください',
            'password.confirmed' => 'パスワード（確認）と異なります',
            'icon.mimes' => 'jpg, png, gif のいずれかの画像を選択してください',
            'comment.max' => 'コメントは30文字以内で入力してください',
        ];
        return Validator::make($request->all(), $rules, $message);
    }

    public function rooms()
    {
        return $this->hasMany('App\Models\Room');
    }
}
