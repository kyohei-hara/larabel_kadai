@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">メニュー</div>

                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            @guest
                                <a class="content-center" href="{{ route("register") }}">新規会員登録</a>
                            @endguest
                            <a class="content-center" href="{{ route("register") }}">商品検索</a>
                            <a class="content-center" href="{{ route("register") }}">お買い物かご</a>
                            <br />
                            @guest
                                <button style="margin:0 auto" onclick="{{ route("login") }}" class="btn btn-primary content-center">
                                    ログイン
                                </button>
                            @else
                                <button style="margin:0 auto" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-danger content-center">
                                    ログアウト
                                </button>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
