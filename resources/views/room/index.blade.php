@extends('layouts.common')

@section('title', 'チャットルーム一覧')

@include('layouts.header')

@section('custom_css')
    <link href="{{ asset('/css/room.css') }}" rel="stylesheet">
@endsection

@section('content')

    <div class="row">
        <!-- タイトル -->
        <div class="offset-md-4 col-md-4 col-12">
            <div class="page-title">{{ $page_title }}</div>
        </div>

        <!-- 検索バー -->
        <div class="col-md-4">
            <form action="/room" method="get">
                @isset($user_id)
                    <input type="hidden" name="user" value="{{ $user_id }}">
                @endisset
                <dl class="search-form">
                    <dt>
                        <input type="text" name="search" placeholder="キーワードを入力" value="{{ $keyword }}" />
                    </dt>
                    <dd>
                        <button><img alt="検索アイコン" src="{{ asset('/img/search.png') }}"></button>
                    </dd>
                </dl>
            </form>
        </div>
    </div>
    
    <!-- ルーム一覧 -->
    <div class="row">
        @foreach ($rooms as $room)
            <div class="col-lg-3 col-md-4 col-6">
                <div class="room rounded border">
                    <a href="/room/{{ $room->id }}">
                        <img src="{{ asset('storage/' . $room->thumbnail) }}" alt="サムネイル" class="img-thumbnail img-responsive">
                        <div class="room-title">{{ $room->title }}</div>
                        <div class="room-owner">投稿者：{{ $room->user->name }}</div>
                        <div class="room-created-date">投稿日：{{ date('Y/m/d G:i:s', strtotime($room->created_at)) }}</div>
                        <div class="room-message=cnt">メッセージ数：{{ $room->chats->count() }}</div>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <!-- ページネーション -->
    <div class="paginate">
        {{ $rooms->links() }}
    </div>
    
@endsection