@extends('layouts.common')

@section('title', 'ユーザー情報')

@include('layouts.header')

@section('custom_css')
    <link href="{{ asset('/css/user.css') }}" rel="stylesheet">
@endsection

@section('custom_js')
    <script src="{{ asset('/js/user.js') }}" defer></script>
@endsection

@section('content')

    <div id="show">

        <div class="page-title">ユーザー情報</div>
        
        <!-- プロフィール -->
        <div class="profile card">
            <div class="card-body">
                <div class="profile-title">
                    <b>{{ $user->name }}</b> さんのプロフィール
                </div>
                <div class="row">
                    <div class="col-lg-2 col-md-3 col-4">
                        <img src="{{ asset('storage/' . $user->icon) }}" alt="アイコン" class="img-fluid">
                    </div>
                    <div class="col-lg-10 col-md-9 col-8">
                        <table>
                            <tr><th>ユーザーID</th></tr>
                            <tr><td class="info">{{ sprintf('%08d', $user->id) }}</td></tr>
                            <tr><th>名前</th></tr>
                            <tr><td class="info">{{ $user->name }}</td></tr>
                            @if (session('user_id') == $user->id)
                            <tr><th>メールアドレス</th></tr>
                            <tr><td class="info">{{ $user->email }}</td></tr>
                            @endif
                            <tr><th>コメント</th></tr>
                            <tr><td class="info">{{ $user->comment }}</td></tr>
                        </table>
                    </div>
                </div>
                @if (session('user_id') == $user->id)
                    <div class="user-edit-btn">
                        <a href="/user/{{ $user->id }}/edit">
                            <button class="btn btn-primary">ユーザー情報を編集</button>
                        </a>
                    </div>
                @elseif (session('user_id') != 1)
                    <div class="user-edit-btn">
                        <input type="hidden" id="user-{{ $user->id }}" value="{{ $followed }}">
                        @if($followed)
                            <button @click="follow({{ $user->id }}, 'user-{{ $user->id }}')" class="btn btn-danger">
                                フォロー解除
                            </button>
                        @else
                            <button @click="follow({{ $user->id }}, 'user-{{ $user->id }}')" class="btn btn-primary">
                                フォローする
                            </button>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <div class="tabs">
            <!-- タブ -->
            <input type="radio" id="tab1" name="tab" checked>
            <label for="tab1" class="tab_lab">フォロー</label>
            <input type="radio" id="tab2" name="tab">
            <label for="tab2" class="tab_lab">フォロワー</label>

            <div class="card follow-follower">
                <!-- フォロー -->
                <table id="follow" class="panel">
                    @foreach ($follows as $follow)
                    <tr>
                        <td>
                            <table>
                                <tr>
                                    <!-- アイコン -->
                                    <td valign="top" class="td-icon">
                                        <a href="/user/{{ $follow->id }}">
                                            <img src="{{ asset('storage/') }}/{{ $follow->icon }}" alt="アイコン" class="follower-icon">
                                        </a>
                                    </td>
                                    <!-- ユーザー名 -->
                                    <td class="td-name">
                                        {{ $follow->name }}
                                    </td>
                                    <!-- フォローボタン -->
                                    <td class="td-btn">
                                        {{-- 自分自身またはゲストユーザーの場合は表示しない --}}
                                        @if ($follow->id != session('user_id') && session('user_id') != 1)
                                            <input type="hidden" id="follow-{{ $follow->id }}" value="{{ $follow->followed }}">
                                            @if(!$follow->followed)
                                                <button @click="follow({{ $follow->id }}, 'follow-{{ $follow->id }}')" class="btn btn-primary">
                                                    フォローする
                                                </button>
                                            @else
                                                <button @click="follow({{ $follow->id }}, 'follow-{{ $follow->id }}')" class="btn btn-danger">
                                                    フォロー解除
                                                </button>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr class="tr-comment">
                        <td class="td-comment">{{ $follow->comment }}</td>
                    </tr>
                    @endforeach
                </table>

                <!-- フォロワー -->
                <table id="follower" class="panel">
                    @foreach ($followers as $follower)
                    <tr>
                        <td>
                            <table>
                                <tr>
                                    <!-- アイコン -->
                                    <td valign="top" class="td-icon">
                                        <a href="/user/{{ $follower->id }}">
                                            <img src="{{ asset('storage/') }}/{{ $follower->icon }}" alt="アイコン" class="follower-icon">
                                        </a>
                                    </td>
                                    <!-- ユーザー名 -->
                                    <td class="td-name">
                                        {{ $follower->name }}
                                    </td>
                                    <!-- フォローボタン -->
                                    <td class="td-btn">
                                        {{-- 自分自身またはゲストユーザーの場合は表示しない --}}
                                        @if ($follower->id != session('user_id') && session('user_id') != 1)
                                            <input type="hidden" id="follower-{{ $follower->id }}" value="{{ $follower->followed }}">
                                            @if(!$follower->followed)
                                                <button @click="follow({{ $follower->id }}, 'follower-{{ $follower->id }}')" class="btn btn-primary">
                                                    フォローする
                                                </button>
                                            @else
                                                <button id="follo" @click="follow({{ $follower->id }}, 'follower-{{ $follower->id }}')" class="btn btn-danger">
                                                    フォロー解除
                                                </button>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr class="tr-comment">
                        <td class="td-comment">{{ $follower->comment }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>

    </div>

@endsection