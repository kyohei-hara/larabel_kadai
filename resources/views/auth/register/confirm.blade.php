@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <span>この内容で登録しますか？</span>
            <div class="card">
                <div class="card-header">会員情報</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('user.resister_resister') }}">
                        @csrf
                        <table class="table table-striped">
                            <tr>
                                <th>氏名</th>
                                <td>{{ $input["name"] }}</td>
                                <input type="hidden" name="name" value="{{ $input["name"] }}">
                                <input type="hidden" name="password" value="{{ $input["password"] }}">
                            </tr>
                            <tr>
                                <th>年齢</th>
                                <td>{{ $input["age"] }}</td>
                                <input type="hidden" name="age" value="{{ $input["age"] }}">
                            </tr>
                            <tr>
                                <th>性別</th>
                                <td>{{ $input["sex"] === 'M' ? '男' : '女'}}</td>
                                <input type="hidden" name="sex" value="{{ $input["sex"] }}">
                            </tr>
                            <tr>
                                <th>郵便番号</th>
                                <td>{{ $input["zip"] }}</td>
                                <input type="hidden" name="zip" value="{{ $input["zip"] }}">
                            </tr>
                            <tr>
                                <th>住所</th>
                                <td>{{ $input["address"] }}</td>
                                <input type="hidden" name="address" value="{{ $input["address"] }}">
                            </tr>
                            <tr>
                                <th>電話</th>
                                <td>{{ $input["tell"] }}</td>
                                <input type="hidden" name="tell" value="{{ $input["tell"] }}">
                            </tr>
                        </table>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    登録
                                </button>

                                <button type="submit" name="back" class="btn btn-light" value="戻る">
                                    戻る
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
