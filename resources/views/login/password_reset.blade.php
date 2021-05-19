@extends('layouts.common')

@section('title', 'ログイン画面')

@include('layouts.header')

@section('custom_css')
    @if(app('env')=='local')
        <link href="{{ asset('/css/login.css') }}" rel="stylesheet">
    @elseif(app('env')=='production')
        <link href="{{ secure_asset('/css/login.css') }}" rel="stylesheet">
    @endif
@endsection

@section('custom_js')

@endsection

@section('content')

    <div class="row">
        <div class="col-md-6 offset-md-3">

            <div class="card">
                <div class="card-body">

                    <div class="title-text">パスワードをリセット</div>

                    <form action="/password_reset" method="post">
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

                        <div class="login">
                            <button type="submit" class="btn btn-primary w-100">メールを送信</button>
                        </div>

                    </form>
                    
                </div>
            </div>

        </div>
    </div>
    
@endsection