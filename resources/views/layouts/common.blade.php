<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title')</title>
        <!-- 共通CSS -->
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/common.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/header.css') }}" rel="stylesheet">
        <!-- 共通JavaScript -->
        <script src="{{ asset('/js/app.js') }}" defer></script>
        <script src="{{ asset('/js/common.js') }}" defer></script>
        <!-- カスタムCSS -->
        @yield('custom_css')
        <!-- カスタムJavaScript -->
        @yield('custom_js')
    </head>
    <body>
        <!-- ヘッダー -->
        @yield('header')

        <!-- フラッシュメッセージ -->
        @if (session('flash_message'))
            <div class="flash_message text-center py-3 my-0">
                {{ session('flash_message') }}
            </div>
        @endif

        <!-- メインコンテンツ -->
        <div class="container">
            @yield('content')
        </div>
        
    </body>
</html>