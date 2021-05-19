@extends('layouts.common')

@section('title', 'ユーザー情報編集')

@include('layouts.header')

@section('custom_css')
    @if(app('env')=='local')
        <link href="{{ asset('/css/user.css') }}" rel="stylesheet">
    @elseif(app('env')=='production')
        <link href="{{ secure_asset('/css/user.css') }}" rel="stylesheet">
    @endif
@endsection

@section('custom_js')
    @if(app('env')=='local')
        <script src="{{ asset('/js/user.js') }}" defer></script>
    @elseif(app('env')=='production')
        <script src="{{ secure_asset('/js/user.js') }}" defer></script>
    @endif
@endsection

@section('content')
    <div id="edit">

        <div class="page-title">ユーザー情報の編集</div>
        
        <div class="card">
            <div class="card-body">
                <form action="/user/{{ $user->id }}" method="post" @submit="submit()" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label class="form-label"><b>ユーザー名</b></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                        @error ('name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label"><b>メールアドレス</b></label>
                        <input type="text" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                        @error ('email')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label"><b>パスワード</b></label>
                        <input type="password" name="password" class="form-control" value="">
                        @error ('password')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label"><b>パスワード（確認）</b></label>
                        <input type="password" name="password_confirmation" class="form-control" value="">
                    </div>

                    <div class="form-group">
                        <label class="form-label"><b>ユーザーアイコン</b></label>
                        <div class="row">
                            <div class="col-lg-2 col-md-3 col-4">
                                <img src="{{ asset('storage/' . $user->icon) }}" alt="アイコン" class="icon" ref="preview">
                            </div>
                            <div class="col-12">
                                <div class="custom-file">
                                    <input type="file" name="icon" class="custom-file-input" id="customFile" accept=".png,.jpg,.gif" ref="fileSelect" @change="previewImage">
                                    <label class="custom-file-label" for="customFile" data-browse="参照" ref="fileLabel">ファイルを選択...</label>
                                    @error ('icon')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label"><b>コメント</b></label>
                        <input type="text" name="comment" class="form-control" value="{{ old('comment', $user->comment) }}">
                        @error ('comment')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="user-edit-btn">
                        <button type="submit"　:disabled="disabled" class="btn btn-primary">変更を保存</button>
                    </div>

                </form>
            </div>
        </div>
    
    </div>
@endsection