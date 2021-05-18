@extends('layouts.common')

@section('title', $room->title)

@include('layouts.header')

@section('custom_css')
    <link href="{{ asset('/css/room.css') }}" rel="stylesheet">
@endsection

@section('custom_js')
    <script src="{{ asset('/js/room.js') }}" defer></script>
@endsection

@section('content')

    <div id="show">
        <input type="hidden" ref="room_id" value="{{ $room->id }}">
        <input type="hidden" ref="owner_id" value="{{ $room->user_id }}">

        <!-- タイトル -->
        <div class="fixed-top fixed-title">
            <div class="container">
                <div class="row">
                    <div class="col-9 room-title2">
                        {{ $room->title }}
                    </div>
                    <div class="col-3 room-edit-btn">
                        @if ($room->user_id == session('user_id'))
                        <a href="/room/{{ $room->id }}/edit">
                            <button class="btn btn-primary">編集</button>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- 投稿 -->
        <div class="bord">
            <template v-for="(chat, index) in chats">
                <div v-if="dateFormat(date, 'YYYYMMDD') != dateFormat(chat.created_at, 'YYYYMMDD') || index == 0" class="date">
                    @{{ date = chat.created_at | moment('YYYY年M月D日') }}
                </div>

                <table class="main-table">
                    <tr>
                        <td valign="top" class="td-icon">
                            <a :href="`/user/${chat.user_id}`">
                                <img :src="`{{ asset('storage/') }}/${chat.user_icon}`" alt="アイコン" class="icon">
                            </a>
                        </td>
                        <td class="td-main">
                            <table class="sub-table">
                                <tr>
                                    <td class="td-name">
                                        <span class="name">@{{ chat.user_name }}</span>
                                        <template v-if="chat.user_id == owner_id">
                                            <img class="owner-icon" alt="オーナーアイコン" src="{{ asset('/img/owner.png') }}">
                                        </template>
                                        <span class="time">@{{ chat.created_at | moment('HH:mm:ss') }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="td-message">
                                        <template v-if="chat.image !== null">
                                            <img :src="`{{ asset('storage/') }}/${chat.image}`" class="image">
                                            <br>
                                        </template>
                                        @{{ chat.message }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </template>
        </div>

        <!-- 入力欄 -->
        <div class="message-form container fixed-bottom">
            <div class="row">
                <div class="col-lg-11 col-md-10 col-9 p-0">
                    <textarea ref="adjust_textarea" v-model="message" class="form-control" rows="1">
                        {{ old('message') }}
                    </textarea>
                </div>
                <div class="col-lg-1 col-md-2 col-3 p-0">
                    <div ref="send_btn" class="send-message-btn">
                        <button @click="send()" :disabled="disabled" class="btn btn-primary">送信</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <input ref="image_file" @change="selectedImage()" type="file" accept=".png,.jpg,.gif">
            </div>
        </div>

    </div>

@endsection