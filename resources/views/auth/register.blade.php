@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">ユーザー新規登録画面</h1>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- メールアドレス --}}
        <div class="form-group mb-3">
            <label for="email">メールアドレス</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        {{-- パスワード --}}
        <div class="form-group mb-3">
            <label for="password">パスワード</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                   name="password" required autocomplete="new-password">

            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        {{-- パスワード確認 --}}
        <div class="form-group mb-4">
            <label for="password-confirm">パスワード（確認）</label>
            <input id="password-confirm" type="password" class="form-control"
                   name="password_confirmation" required autocomplete="new-password">
        </div>

        {{-- ボタンたち --}}
        <div class="form-group d-flex justify-content-between">
            <a class="btn btn-secondary" href="{{ route('login') }}">戻る</a>
            <button type="submit" class="btn btn-primary">新規登録</button>
        </div>
    </form>
</div>
@endsection
