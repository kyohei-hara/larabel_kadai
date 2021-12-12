@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <span>会員情報を入力してください。</span>
            <div class="card">
                <div class="card-header">会員情報</div>

                <div class="card-body">
                    <form method="POST" action="/confirm">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">氏名</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">パスワード</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">確認用パスワード</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control @error('password_confirm') is-invalid @enderror" name="password_confirm" required autocomplete="new-password">
                            </div>

                             @error('password_confirm')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="form-group row">
                            <label for="age" class="col-md-4 col-form-label text-md-right">年齢</label>

                            <div class="col-md-6">
                                <input id="age" type="number" class="form-control @error('age') is-invalid @enderror" name="age" value="{{ old('age') }}" required autocomplete="age" min="0">

                                @error('age')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sex" class="col-md-4 col-form-label text-md-right">性別</label>

                            <div class="col-md-6">
                                <select id="sex" name="sex" class="form-control">
                                    <option value="M" @if(old('sex')=='M') selected  @endif>男性</option>
                                    <option value="F" @if(old('sex')=='F') selected  @endif>女性</option>
                                </select>
                                @error('sex')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="zip" class="col-md-4 col-form-label text-md-right">郵便番号</label>

                            <div class="col-md-6">
                                <input id="zip" type="text" class="form-control @error('zip') is-invalid @enderror" name="zip" value="{{ old('zip') }}" required autocomplete="zip">

                                @error('zip')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">住所</label>

                            <div class="col-md-6">
                                <textarea id="address" name="address" class="md-textarea form-control" rows="3">{{ old('address') }}</textarea>
                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tell" class="col-md-4 col-form-label text-md-right">電話番号</label>

                            <div class="col-md-6">
                                <input id="tell" type="text" class="form-control @error('tell') is-invalid @enderror" name="tell" value="{{ old('tell') }}" required autocomplete="tell">

                                @error('tell')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    登録
                                </button>

                                <button type="button" onClick="cleare()" class="btn btn-light">
                                    戻る
                                </button>

                                <button type="button" onClick="cleare()" class="btn btn-light">
                                    クリア
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function cleare() {
        const name = document.getElementById("name");
        const password = document.getElementById("password");
        const password_confirm = document.getElementById("password-confirm");
        const age = document.getElementById("age");
        const sex = document.getElementById("sex");
        const zip = document.getElementById("zip");
        const tell = document.getElementById("tell");
        const address = document.getElementById("address");
        name.value="";
        password.value="";
        password_confirm.value="";
        age.value="";
        sex.value="M";
        zip.value="";
        tell.value="";
        address.value="";
    }
</script>
@endsection
