@extends('layouts.common')

@section('title', 'チャットルーム一覧')

@include('layouts.header')

@section('custom_css')
    @if(app('env')=='local')
        <link href="{{ asset('/css/room.css') }}" rel="stylesheet">
    @elseif(app('env')=='production')
        <link href="{{ secure_asset('/css/room.css') }}" rel="stylesheet">
    @endif
@endsection

@section('content')

    <div class="row">
        <!-- タイトル -->
        <div class="offset-md-4 col-md-4 col-12">
            <div class="page-title">フォロールーム</div>
        </div>

        <!-- 検索バー -->
        <div class="col-md-4">
            <form action="/followRoom" method="get">
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