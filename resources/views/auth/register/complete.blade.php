@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">登録完了</div>
                    <div class="card-body">

                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <span class="content-center">会員登録が完了しました。</span>
                                <span class="content-center">あなたの会員NOは{{ Auth::user()->MEMBER_NO }}です。</span>
                                <a href="{{ route('home') }}">
                                    <button style="margin: 0 auto" class="btn btn-light content-center">
                                        メニューへ
                                    </button>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
