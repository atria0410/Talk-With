@extends('layouts.common')

@section('title', 'ルーム作成')

@include('layouts.header')

@section('custom_css')
    <link href="{{ asset('/css/room.css') }}" rel="stylesheet">
@endsection

@section('custom_js')
    <script src="{{ asset('/js/room.js') }}" defer></script>
@endsection

@section('content')
    <div id="new">
        <div class="page-title">ルーム作成</div>
        <div class="card">
            <div class="card-body">
                <form action="/room" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">タイトル（必須）</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                        @error ('title')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label"><b>サムネイル（任意）</b></label>
                        <div class="row">
                            <div class="col-lg-2 col-md-3 col-4">
                                <img src="{{ asset('storage/thumbnail/default.jpg') }}" alt="サムネイル" class="thumbnail" ref="preview">
                            </div>
                            <div class="col-12">
                                <div class="custom-file">
                                    <input type="file" name="thumbnail" class="custom-file-input" id="customFile" accept=".png,.jpg,.gif" ref="fileSelect" @change="uploadFile">
                                    <label class="custom-file-label" for="customFile" data-browse="参照" ref="fileLabel">ファイルを選択...</label>
                                    @error ('thumbnail')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="room-create-btn">
                        <button type="submit" class="btn btn-primary">ルームを作成</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection