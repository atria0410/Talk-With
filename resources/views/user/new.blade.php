@extends('layouts.common')

@section('title', 'ユーザー情報編集')

@include('layouts.header')

@section('custom_css')
    <link href="{{ asset('/css/user.css') }}" rel="stylesheet">
@endsection

@section('custom_js')
    <script src="{{ asset('/js/user.js') }}" defer></script>
@endsection

@section('content')
    <div id="new">

        <div class="page-title">新規登録</div>
        
        <div class="card">
            <div class="card-body">
                <form action="/user/new" method="post" @submit="submit()" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-group">
                        <label class="form-label"><b>ユーザー名</b></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                        @error ('name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label"><b>メールアドレス</b></label>
                        <input type="text" name="email" class="form-control" value="{{ old('email') }}">
                        @error ('email')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label"><b>パスワード</b></label>
                        <input type="password" name="password" class="form-control">
                        @error ('password')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label"><b>パスワード（確認）</b></label>
                        <input type="password" name="password_confirmation" class="form-control" value="">
                    </div>

                    <div class="user-create-btn">
                        <button type="submit" :disabled="disabled" class="btn btn-primary">登録</button>
                    </div>

                </form>
            </div>
        </div>

    </div>
@endsection