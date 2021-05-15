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
        <input type="hidden" ref="strage_path" value="{{ asset('storage/') }}">
        <input type="hidden" ref="user_id" value="{{ $user->id }}">
        <input type="hidden" ref="followed" value="{{ $followed }}">

        <div class="page-title">ユーザー情報</div>
        
        <div class="card">
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
                        <input type="hidden" :id="user_id" :value="followed">
                        <button v-if="followed" :id="`btn${user_id}`" @click="follow(user_id)" class="btn btn-danger">
                            フォロー解除
                        </button>
                        <button v-else :id="`btn${user_id}`" @click="follow(user_id)" class="btn btn-primary">
                            フォローする
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <div class="follower">
            <div class="sub-page-title">フォロワー</div>

            <div class="card">
                <table>
                    <template v-for="(follower, index) in followers">
                        <tr>
                            <td>
                                <table>
                                    <tr>
                                        <td valign="top" class="td-follower-icon">
                                            <a :href="`/user/${follower.id}`">
                                                <img :src="`${stragePath}/${follower.icon}`" alt="アイコン" class="follower-icon">
                                            </a>
                                        </td>
                                        <td class="td-follower-name">
                                            @{{ follower.name }}
                                        </td>
                                        <td class="td-follower-btn">
                                            <input type="hidden" :id="follower.id" :value="follower.followed">
                                            @if (session('user_id') != 1)
                                            <template v-if="follower.id != {{ session('user_id') }}">
                                                <button v-if="follower.followed" :id="`btn${follower.id}`" @click="follow(follower.id)" class="btn btn-danger">フォロー解除</button>
                                                <button v-else :id="`btn${follower.id}`" @click="follow(follower.id)" class="btn btn-primary">フォローする</button>
                                            </template>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="tr-follower-comment">
                            <td class="td-follower-comment">@{{ follower.comment }}</td>
                        </tr>
                    </template>
                </table>
            </div>
        </div>

    </div>

@endsection