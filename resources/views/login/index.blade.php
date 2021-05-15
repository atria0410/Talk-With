@extends('layouts.common')

@section('title', 'ログイン画面')

@include('layouts.header')

@section('custom_css')
    <link href="{{ asset('/css/login.css') }}" rel="stylesheet">
@endsection

@section('custom_js')

@endsection

@section('content')

    <div class="row">
        <div class="col-md-6 offset-md-3">

            <div class="card">
                <div class="card-body">

                    <div class="title-text">ログイン</div>

                    <form action="/login" method="post">
                        @csrf
                        
                        @error ('msg')
                            <div class="message">{{ $message }}</div>
                        @enderror

                        <div class="form-group">
                            <label>メールアドレス</label>
                            <input type="text" name="email" class="form-control" value="{{ old('email') }}">
                            @error ('email')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>パスワード</label>
                            <input type="password" name="password" class="form-control">
                            @error ('password')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="login">
                            <button type="submit" class="btn btn-primary w-100">ログイン</button>
                        </div>

                        <div class="password_reminder mx-auto">
                            <a href="/password_reset">パスワードをお忘れの方</a>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6 guest-login">
                                <a href="/guestlogin" class="btn btn-primary w-100">ゲストログイン</a>
                            </div>

                            <div class="col-md-6 sign-up">
                                <a href="/user/new" class="btn btn-success w-100">新規登録</a>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>

        </div>
    </div>
    
@endsection