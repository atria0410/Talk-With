<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Validator;

class Chat extends Model
{
    protected $guarded = ['id'];

    /* バリデーション */
    public static function validation($request)
    {
        $rules = [
            'message' => 'required_without_all:image',
            'image' => ''
        ];
        return Validator::make($request->all(), $rules);
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
