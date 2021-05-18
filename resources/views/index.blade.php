@extends('layouts.common')

@section('title', 'Talk With')

@include('layouts.header')

@section('custom_css')
    <link href="{{ asset('/css/top.css') }}" rel="stylesheet">
@endsection

@section('content')

    <div class="title">
        <div class="title-text">
            Welcom to the<br>
            Talk With
        </div>
    </div>

    <div class="description">
        <div class="description-text">
            <div class="description-main">
                Talk With とは ?
            </div>
            <div class="description-sub">
                Talk withでは趣味の会う仲間と気軽にリアルタイムチャットを行えます。<br>
                興味のあるルームに参加して趣味の合う仲間と盛り上がろう！
            </div>
        </div>
    </div>

    <div class="sign-in row">
        <div class="sigin-in-btn offset-lg-4 col-lg-4 offset-2 col-8">
            <a href="/login" class="btn btn-success w-100">
                サインイン
            </a>
        </div>
    </div>

@endsection