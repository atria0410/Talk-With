<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use InterventionImage;
use App\Models\Room;
use App\Models\Chat;
use App\Models\User;
use App\Models\Follow;
use App\Events\MessageCreated;

class RoomController extends Controller
{

    /***********************************************************/
    /* ルーム一覧ページ                                         */
    /***********************************************************/
    public function index(Request $request)
    {
        // URLパラメータを取得
        $user_id = $request->input('user');
        $keyword = $request->input('search');

        $page_title = 'オープンルーム';
        $rooms = Room::orderBy('created_at', 'desc');      

        // ユーザー指定がある場合
        if(isset($user_id)) {
            $user = User::find($user_id);
            $page_title = $user->name . ' さんのルーム';
            $rooms->where('user_id', $user_id);
        }
        // キーワード指定がある場合
        if(isset($keyword)) {
            $rooms->where('title', 'LIKE', '%'. $keyword . '%');
        }

        $rooms = $rooms->paginate(16);

        $params = [
            'rooms' => $rooms,
            'page_title' => $page_title,
            'user_id' => $user_id,
            'keyword' => $keyword
        ];
        
        return view('room.index', $params);
    }

    /***********************************************************/
    /* フォローしているユーザーのルーム一覧ページ                  */
    /***********************************************************/
    public function followRoom(Request $request)
    {
        // URLパラメータを取得
        $keyword = $request->input('search');

        $follows = Follow::where('user_id', session('user_id'))
                         ->get();

        $follow_ids = array();
        foreach ($follows as $follow) {
            array_push($follow_ids, $follow['follow_id']);
        }

        $rooms = Room::whereIn('user_id', $follow_ids)
                     ->orderBy('created_at', 'desc');      

        // キーワード指定がある場合
        if(isset($keyword)) {
            $rooms->where('title', 'LIKE', '%'. $keyword . '%');
        }

        $rooms = $rooms->paginate(16);

        $params = [
            'rooms' => $rooms,
            'keyword' => $keyword
        ];
        
        return view('room.follow', $params);
    }

    /***********************************************************/
    /* チャットページ                                           */
    /***********************************************************/
    public function show($room_id)
    {
        // ルームを取得
        $room = Room::find($room_id);

        if (is_null($room)) {
            // ルームが存在しない場合はリダイレクト
            echo "<script>alert('ルームが存在しません。')</script>;";
            $previous_url = parse_url(url()->previous(), PHP_URL_PATH);
			return redirect($previous_url);
        }

        return view('room.show', ['room' => $room]);
    }

    /***********************************************************/
    /* ルーム作成ページ                                         */
    /***********************************************************/
    public function new()
    {
        return view('room.new');
    }

    /***********************************************************/
    /* ルーム作成処理                                           */
    /***********************************************************/
    public function create(Request $request)
    {
        // バリデーションチェック
        $validator = Room::validation($request);
        if ($validator->fails()) {
            return redirect('/room/new')
                    ->withErrors($validator)
                    ->withInput();
        }

        $filePath = 'thumbnail/default.jpg';

        // DBに保存
        $room = new Room;
        $room->user_id = session('user_id');
        $room->title = $request->title;
        $room->thumbnail = $filePath;
        $room->save();

        // 画像を[strage/app/public/thumbnail]に保存
        $thumbnail = $request->thumbnail;
        if (!is_null($thumbnail)) {
            $filePath = 'thumbnail/room' . $room->id . '.jpg';

            $thumbnail = InterventionImage::make($thumbnail)
                ->encode('jpg')
                ->fit(512, 512)
                ->save(storage_path() . '/app/public/' . $filePath);

            $room->thumbnail = $filePath;
            $room->save();
        }

        return redirect('/room');
    }

    /***********************************************************/
    /* メッセージ送信処理                                       */
    /***********************************************************/
    public function send(Request $request, $room_id)
    {
        // バリデーションチェック
        // メッセージか画像のどちらかは必須
        $validator = Chat::validation($request);
        if ($validator->fails()) {
            return;
        }

        // DBに保存
        $chat = new Chat;
        $chat->room_id = $room_id;
        $chat->user_id = session('user_id');
        $chat->save();

        if (!is_null($request->message)) {
            $chat->message = $request->message;
        }

        $image = $request->image;
        if (!is_null($image)) {
            $filePath = 'chat/image' . $chat->id . '.jpg';

            $image = InterventionImage::make($image)
                ->encode('jpg')
                ->resize(150, null, function($constraint){
                    $constraint->aspectRatio();
                })
                ->save(storage_path() . '/app/public/' . $filePath);

            $chat->image = $filePath;     
        }

        $chat->save();

        event(new MessageCreated($chat));
    }

    /***********************************************************/
    /* チャットデータを取得                                     */
    /***********************************************************/
    public function get($room_id)
    {
        $chats = Chat::select(['chats.*', 'users.name AS user_name', 'users.icon AS user_icon'])
                     ->leftjoin('users', 'chats.user_id', '=', 'users.id')
                     ->where('room_id', $room_id)
                     ->orderBy('chats.created_at')
                     ->orderBy('id')
                     ->get();

        $json = json_encode($chats);

        echo $json;
    }

}
