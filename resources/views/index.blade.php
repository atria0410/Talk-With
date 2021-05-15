@extends('layouts.common')

@section('title', 'Talk With')

@include('layouts.header')

@section('custom_css')
    <link href="{{ asset('/css/top.css') }}" rel="stylesheet">
@endsection

@section('content')
    <h1 class="text-center title">Talk Withとは？</h1>
    <div class="row description">
        <div class="offset-lg-2 col-md-8 offset-md-3 col-md-6 col-12">
        Talk_withでは趣味の会う仲間と気軽にリアルタイムチャットを行えます。
        <br>
        ルームを作成したり、他の人の作成したルームに参加して様々な話題で盛り上がりましょう！
    </div>
@endsection