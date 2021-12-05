@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <a class="text-right" style="display:block" href="{{ route('register') }}">新規登録はこちら</a>
            <div class="card">
                <div class="card-header">認証OK</div>
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
