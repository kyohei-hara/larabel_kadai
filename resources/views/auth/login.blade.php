@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <a class="text-right" style="display:block" href="{{ route('register') }}">新規登録はこちら</a>
            <div class="card">
                <div class="card-header">ログイン</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="member_no" class="col-md-4 col-form-label text-md-right">会員NO</label>

                            <div class="col-md-6">
                                <input id="member_no" type="text" class="form-control @error('member_no') is-invalid @enderror" name="member_no" required autocomplete="member-no" autofocus>

                                @error('member_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="pass" class="col-md-4 col-form-label text-md-right">パスワード</label>

                            <div class="col-md-6">
                                <input id="pass" type="password" class="form-control @error('pass') is-invalid @enderror" name="pass" required autocomplete="current-pass">

                                @error('pass')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                              <span class="text-danger" role="alert">
                                <strong>{{ $message ?? '' }}</strong>
                              </span>
                            </div>
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    ログイン
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
        const member_no = document.getElementById("member_no");
        const pass = document.getElementById("pass");
        member_no.value="";
        pass.value="";
    }
</script>
@endsection
