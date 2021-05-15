<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Validator;

class Room extends Model
{
    protected $guarded = ['id'];

    /* バリデーション */
    public static function validation($request)
    {
        $rules = [
            'title' => 'required',
            'thumbnail' => 'mimes:jpeg,gif,png'
        ];
        $message = [
            'title.required' => 'タイトルを入力してください',
            'thumbnail.mimes' => 'jpg, png, gif のいずれかの画像を選択してください'
        ];
        return Validator::make($request->all(), $rules, $message);
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function chats()
    {
        return $this->hasMany('App\Models\Chat');
    }
}
