@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="justify-content-center" style="text-align: center">
            注文が完了しました。
            <br />
            <a href="{{ route("home") }}">
                <button type="button" class="btn btn-secondary">
                    メニューに戻る
                </button>
            </a>
        </div>
    </div>
@endsection
