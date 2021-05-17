@section('header')
<div class='fixed-top'>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container">
            <a href="/" class="navbar-brand talk-with">Talk With</a>
            
            @if (session('login'))
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav mr-auto">
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="/room">オープンルーム</a>
                        </li>
                        @if(session('user_id') != 1) {{-- ゲストユーザーの場合は表示しない --}}
                        <li class="nav-item">
                            <a class="nav-link" href="/followRoom">フォロールーム</a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:createRoom({{ session('user_id') }})">ルームを作成する</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{ asset('storage/' . session('user_icon')) }}" alt="アイコン" class="user-icon">
                                &nbsp{{ session('user_name') }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @if(session('user_id') != 1) {{-- ゲストユーザーの場合は表示しない --}}
                                <a class="dropdown-item" href="/user/{{ session('user_id') }}">ユーザ情報</a>
                                <a class="dropdown-item" href="/room?user={{ session('user_id') }}">あなたのルーム</a>
                                <div class="dropdown-divider"></div>
                                @endif
                                <a class="dropdown-item" href="/logout">ログアウト</a>
                            </div>
                        </li>           
                    </ul>
                </div>
            @endif

        </div>
    </nav>
</div>
@endsection