@extends('layouts.common')

@section('title', 'ルーム編集')

@include('layouts.header')

@section('custom_css')
    @if(app('env')=='local')
        <link href="{{ asset('/css/room.css') }}" rel="stylesheet">
    @elseif(app('env')=='production')
        <link href="{{ secure_asset('/css/room.css') }}" rel="stylesheet">
    @endif
@endsection

@section('custom_js')
    @if(app('env')=='local')
        <script src="{{ asset('/js/room.js') }}" defer></script>
    @elseif(app('env')=='production')
        <script src="{{ secure_asset('/js/room.js') }}" defer></script>
    @endif
@endsection

@section('content')
    <div id="edit">
        <div class="page-title">ルーム編集</div>
        <div class="card">
            <div class="card-body">
                <form method="post" @submit="submit()" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">タイトル（必須）</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $room->title) }}">
                        @error ('title')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label"><b>サムネイル（任意）</b></label>
                        <div class="row">
                            <div class="col-lg-2 col-md-3 col-4">
                                <img src="{{ asset('storage/' . $room->thumbnail) }}" alt="サムネイル" class="thumbnail" ref="preview">
                            </div>
                            <div class="col-12">
                                <div class="custom-file">
                                    <input type="file" name="thumbnail" class="custom-file-input" id="customFile" accept=".png,.jpg,.gif" ref="fileSelect" @change="previewImage">
                                    <label class="custom-file-label" for="customFile" data-browse="参照" ref="fileLabel">ファイルを選択...</label>
                                    @error ('thumbnail')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="room-create-btn">
                        <div class="row">
                            <div class="offset-lg-2 col-lg-3 col-6">
                                <button type="submit" formaction="/room/{{ $room->id }}" class="btn btn-primary btn-update">更新</button>
                            </div>
                            <div class="offset-lg-2 col-lg-3 col-6">
                                <button type="submit" formaction="/room/{{ $room->id }}/delete" class="btn btn-danger btn-delete">削除</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection