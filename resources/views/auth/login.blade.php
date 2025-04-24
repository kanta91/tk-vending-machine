@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">ユーザーログイン画面</h2>

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- メールアドレス -->
        <div class="mb-3">
            <label for="email" class="form-label">メールアドレス</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

            @error('email')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
        </div>

        <!-- パスワード -->
        <div class="mb-3">
            <label for="password" class="form-label">パスワード</label>
            <input id="password" type="password"
                class="form-control @error('password') is-invalid @enderror"
                name="password" required autocomplete="current-password">

            @error('password')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
        </div>

        <!-- ボタンたち -->
        <div class="d-flex justify-content-between">
            <a class="btn btn-secondary" href="{{ route('register') }}">新規登録</a>
            <button type="submit" class="btn btn-primary">ログイン</button>
        </div>
    </form>
</div>
@endsection
